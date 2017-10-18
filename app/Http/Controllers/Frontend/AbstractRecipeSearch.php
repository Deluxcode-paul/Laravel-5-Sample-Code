<?php

namespace App\Http\Controllers\Frontend;

use App\Enums\CookTime;
use App\Enums\RecipesSorting;
use App\Enums\Search;
use App\Models\Allergen;
use App\Models\BlessingType;
use App\Models\Cuisine;
use App\Models\Diet;
use App\Models\Holiday;
use App\Models\Ingredient;
use App\Models\Preference;
use App\Models\Recipe;
use App\Models\RecipeCategory;
use App\Models\Source;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;

/**
 * Class AbstractRecipeSearch
 * @package App\Http\Controllers\Frontend
 */
abstract class AbstractRecipeSearch extends AbstractBaseSearch
{
    protected $parameters;
    protected $parametersKeys = [];
    protected $singleParameters = [];

    /**
     * Init
     */
    protected function init()
    {
        $this->singleParameters = [
            Search::P_PREFERENCES,
            Search::P_PAGESIZE,
            Search::P_SORT,
            Search::P_FEATURED
        ];

        return parent::init();
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function __invoke(Request $request)
    {
        $this->readInputVars($request);
        if ($this->applyUserPreferences && empty($request->get(Search::P_SECONDARY)) && $this->currentUser) {
            return $this->applyUserPreferences($this->currentUser);
        }

        $parameters = $this->calculateParameters();
        $result = $this->getResult();

        return $this->render([
            'currentUrl' => \Request::url(),
            'title' => $parameters->get('header'),
            'results' => $this->getResultsJsonData($result, $parameters),
            'noResults' => $this->getNoResultsJson(),
            'ingredients' => Ingredient::all()->pluck('title', 'id')
        ]);
    }

    /**
     * @return Collection
     */
    protected function calculateParameters()
    {
        $result = parent::calculateParameters();
        $result->put('activePreference', $this->getActivePreference());

        return $result;
    }

    /**
     * @return mixed|string
     */
    protected function getActivePreference()
    {
        $active = $this->getSelected(Search::P_PREFERENCES)->first();

        return $active ? $active : 'all';
    }

    /**
     * @return mixed
     */
    protected function getResult()
    {
        /** @var Builder $query */
        $query = Recipe::published()->with('user')->select(['recipes.*']);
        $this->applyParametersToQuery($query);

        return $query->distinct();
    }

    /**
     * @return string
     */
    protected function getHeader()
    {
        $title = trans('recipes/list.title_default');
        $countOfSelectedFilter = $this->getCountOfFilters();

        switch ($countOfSelectedFilter) {
            case 0:
                if ($this->isOrderedByRecent()) {
                    $title = trans('recipes/list.title_new_recipes');
                }
                break;
            case 1:
                $title = $this->getHeaderByFilter();
                break;
            default:
                break;
        }

        return $title;
    }

    /**
     * @return mixed
     */
    protected function getCountOfFilters()
    {
        return $this->getParametersForHeader()->map(function ($item) {
            return count($item);
        })->sum();
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    protected function getParametersForHeader()
    {
        $params = $this->parameters;

        unset($params[Search::P_SORT]);
        unset($params[Search::P_PAGESIZE]);
        unset($params[Search::P_PREFERENCES]);
        unset($params[Search::P_INGREDIENTS_WITH]);
        unset($params[Search::P_INGREDIENTS_WITHOUT]);
        unset($params[Search::P_SECONDARY]);

        return collect($params);
    }

    /**
     * @return bool
     */
    protected function isOrderedByRecent()
    {
        $selected = $this->getSelected(Search::P_SORT);

        return (0 == $selected->count()) || (RecipesSorting::MOST_RECENT == $selected->first());
    }

    /**
     * @return string
     */
    protected function getHeaderByFilter()
    {
        $params = $this->getParametersForHeader();
        $params = $params->mapWithKeys(function ($item, $key) {
            return count($item) ? [$key => $item] : null;
        });
        $key = (1 == $params->count()) ? $params->keys()->first() : null;

        return $this->getTitleByKey($key, $params->first());
    }

    /**
     * @param string $key
     * @param mixed $value
     * @return string
     */
    protected function getTitleByKey($key, $value)
    {
        $title = '';

        if ($key) {
            switch ($key) {
                case Search::P_FEATURED:
                    $title = trans('recipes/list.title_featured');
                    break;
                case Search::P_COOK_TIMES:
                    $value = $this->getSelected(Search::P_COOK_TIMES)->first();
                    $title = CookTime::label($value);
                    $title .= ' ' . trans('recipes/list.title_recipes_part');
                    break;
                default:
                    $modelName = $this->getModelByKey($key);
                    if ($modelName) {
                        $model = call_user_func_array(['App\Models\\' . $modelName, 'find'], [$value])->first();
                        switch ($modelName) {
                            case 'User':
                                $title = $model->fullName;
                                break;
                            case 'Allergen':
                                $title = trans('recipes/list.allergens-title') . ' ' .$model->title;
                                break;
                            default:
                                $title = $model->title;
                                break;
                        }

                        $title .= ' ' . trans('recipes/list.title_recipes_part');
                    }
                    break;
            }
        }

        return $title;
    }

    /**
     * @param $key
     * @return bool|mixed
     */
    protected function getModelByKey($key)
    {
        $models = [
            Search::P_ALLERGENS => 'Allergen',
            Search::P_DIETS => 'Diet',
            Search::P_HOLIDAYS => 'Holiday',
            Search::P_CHEFS => 'User',
            Search::P_SOURCES => 'Source',
            Search::P_CUISINES => 'Cuisine',
            Search::P_CATEGORIES => 'RecipeCategory',
            Search::P_BLESSING_TYPES => 'BlessingType',
        ];

        return isset($models[$key]) ? $models[$key] : false;
    }

    /**
     * @param Builder $query
     */
    protected function applyQueryByPreferences(Builder &$query)
    {
        $values = $this->getSelected(Search::P_PREFERENCES);
        if ($values->count() > 0 && 'all' != $values->first()) {
            $values = $values->first();
            $query->where('preference_id', '=', $values);
        }
    }

    /**
     * @param Builder $query
     */
    protected function applyQueryByIngredientsWith(Builder &$query)
    {
        $valuesIn = $this->getSelected(Search::P_INGREDIENTS_WITH);
        $valuesNotIn = $this->getSelected(Search::P_INGREDIENTS_WITHOUT);
        if ($valuesIn->count() > 0 || $valuesNotIn->count() > 0) {
            if ($valuesIn->count() > 0) {
                $query->whereHas('ingredients', function ($whereQuery) use ($valuesIn) {
                    $whereQuery->whereIn('ingredients.id', $valuesIn);
                });
            }

            if ($valuesNotIn->count() > 0) {
                $query->whereDoesntHave('ingredients', function ($whereQuery) use ($valuesNotIn) {
                    $whereQuery->whereIn('ingredients.id', $valuesNotIn);
                });
            }
        }
    }

    /**
     * @param Builder $query
     * @return array
     */
    protected function applyQueryByAllergens(Builder &$query)
    {
        $values = $this->getSelected(Search::P_ALLERGENS);

        if ($values->count() > 0) {
            $query->whereDoesntHave('allergens', function ($whereQuery) use ($values) {
                $whereQuery->whereIn('allergens.id', $values);
            });
        }
    }

    /**
     * @param Builder $query
     */
    protected function applyQueryByDiets(Builder &$query)
    {
        $values = $this->getSelected(Search::P_DIETS);

        if ($values->count() > 0) {
            $query->whereHas('diets', function ($whereQuery) use ($values) {
                $whereQuery->whereIn('diets.id', $values);
            });
        }
    }

    /**
     * @param Builder $query
     */
    protected function applyQueryByHolidays(Builder &$query)
    {
        $values = $this->getSelected(Search::P_HOLIDAYS);

        if ($values->count() > 0) {
            $query->whereHas('holidays', function ($whereQuery) use ($values) {
                $whereQuery->whereIn('holidays.id', $values);
            });
        }
    }

    /**
     * @param Builder $query
     */
    protected function applyQueryByCookTimes(Builder &$query)
    {
        $values = $this->getSelected(Search::P_COOK_TIMES);
        if ($values->count() > 0) {
            $query->where(function ($whereQuery) use ($values) {
                foreach ($values as $value) {
                    switch ($value) {
                        case CookTime::QUICK:
                            $whereQuery->orWhere('cook_time', '<', CookTime::TIME_LIMIT_QUICK);
                            break;
                        case CookTime::MEDIUM:
                            $whereQuery->orWhere(function ($orWhereQuery) {
                                $orWhereQuery->where('cook_time', '>=', CookTime::TIME_LIMIT_QUICK);
                                $orWhereQuery->where('cook_time', '<', CookTime::TIME_LIMIT_MEDIUM);
                            });
                            break;
                        case CookTime::LONG:
                            $whereQuery->orWhere(function ($orWhereQuery) {
                                $orWhereQuery->where('cook_time', '>=', CookTime::TIME_LIMIT_MEDIUM);
                                $orWhereQuery->where('cook_time', '<', CookTime::TIME_LIMIT_LONG);
                            });
                            break;
                        case CookTime::LONGER:
                        default:
                            $whereQuery->orWhere('cook_time', '>=', CookTime::TIME_LIMIT_LONGER);
                            break;
                    }
                }
            });
        }
    }

    /**
     * @param Builder $query
     */
    protected function applyQueryByChefs(Builder &$query)
    {
        $values = $this->getSelected(Search::P_CHEFS);

        if ($values->count() > 0) {
            $query->whereIn('user_id', $values);
        }
    }

    /**
     * @param Builder $query
     */
    protected function applyQueryBySources(Builder &$query)
    {
        $values = $this->getSelected(Search::P_SOURCES);

        if ($values->count() > 0) {
            $query->whereHas('sources', function ($whereQuery) use ($values) {
                $whereQuery->whereIn('sources.id', $values);
            });
        }
    }

    /**
     * @param Builder $query
     */
    protected function applyQueryByCuisines(Builder &$query)
    {
        $values = $this->getSelected(Search::P_CUISINES);

        if ($values->count() > 0) {
            $query->whereHas('cuisines', function ($whereQuery) use ($values) {
                $whereQuery->whereIn('cuisines.id', $values);
            });
        }
    }

    /**
     * @param Builder $query
     */
    protected function applyQueryByBlessingTypes(Builder &$query)
    {
        $values = $this->getSelected(Search::P_BLESSING_TYPES);

        if ($values->count() > 0) {
            $query->whereIn('blessing_type_id', $values);
        }
    }

    /**
     * @param Builder $query
     */
    protected function applyQueryByCategories(Builder &$query)
    {
        $values = $this->getSelected(Search::P_CATEGORIES);

        if ($values->count() > 0) {
            $query->whereHas('categories', function ($whereQuery) use ($values) {
                $whereQuery->whereIn('recipe_categories.id', $values);
            });
        }
    }

    /**
     * @param Builder $query
     */
    protected function applyQueryByFeatured(Builder &$query)
    {
        $values = $this->getSelected(Search::P_FEATURED)->first();

        if ($values) {
            $values = is_array($values) ? array_first($values) : $values;
            $values = ('on' == $values) ? 1 : 0;
            $query->where('is_featured', '=', $values);
        }
    }

    /**
     * @param Builder $query
     */
    protected function applyQueryBySort(Builder &$query)
    {
        $selected = $this->getSelected(Search::P_SORT)->first();

        switch ($selected) {
            case RecipesSorting::MOST_POPULAR:
                $query->mostPopular();
                break;
            case RecipesSorting::MOST_SHARED:
                $query->mostShared();
                break;
            case RecipesSorting::MOST_TITLE_ASC:
                $query->orderBy('title', 'asc');
                break;
            case RecipesSorting::MOST_TITLE_DESC:
                $query->orderBy('title', 'desc');
                break;
            case RecipesSorting::MOST_RECENT:
            default:
                $query->orderBy('updated_at', 'desc');
                break;
        }
    }

    /**
     * @return array
     */
    protected function getSort()
    {
        return [
            'key' => Search::P_SORT,
            'all' => RecipesSorting::labels(),
            'selected' => $this->getSelected(Search::P_SORT)->flip()->keys()->first(),
            'label' => trans('recipes/list.sort')
        ];
    }

    /**
     * @return array
     */
    protected function getPreferences()
    {
        $result = $this->resolveParametersWithAll(
            Preference::class,
            Search::P_PREFERENCES,
            trans('recipes/list.sidebar_title')
        );
        $result['all']->prepend(trans('recipes/list.all'), 'all');
        $result['multiple'] = 0;
        $result['dependent'] = 0;

        return $result;
    }

    /**
     * @return array
     */
    protected function getIngredientsWith()
    {
        $result = $this->resolveParameters(
            Ingredient::class,
            Search::P_INGREDIENTS_WITH,
            trans('recipes/list.with')
        );
        $result['dependent'] = 0;

        return $result;
    }

    /**
     * @return array
     */
    protected function getIngredientsWithout()
    {
        $result = $this->resolveParameters(
            Ingredient::class,
            Search::P_INGREDIENTS_WITHOUT,
            trans('recipes/list.without')
        );
        $result['dependent'] = 0;

        return $result;
    }

    /**
     * @return array
     */
    protected function getAllergens()
    {
        $result = $this->resolveParametersWithAll(
            Allergen::class,
            Search::P_ALLERGENS,
            trans('recipes/list.allergens-title')
        );

        $preferences = $this->getAllPreferences();

        foreach ($preferences as $preference) {
            $result[$preference->id] = Allergen::whereHas('preferences', function ($query) use ($preference) {
                $query->where('preference_id', '=', $preference->id);
            })->pluck('title', 'id');
        }

        return $result;
    }

    /**
     * @return array
     */
    protected function getDiets()
    {
        $result = $this->resolveParametersWithAll(
            Diet::class,
            Search::P_DIETS,
            trans('recipes/list.diets-title')
        );

        $preferences = $this->getAllPreferences();

        foreach ($preferences as $preference) {
            $result[$preference->id] = Diet::whereHas('preferences', function ($query) use ($preference) {
                $query->where('preference_id', '=', $preference->id);
            })->pluck('title', 'id');
        }

        return $result;
    }

    /**
     * @return array
     */
    protected function getHolidays()
    {
        $result = $this->resolveParametersWithAll(
            Holiday::class,
            Search::P_HOLIDAYS,
            trans('recipes/list.holidays-title')
        );

        $preferences = $this->getAllPreferences();

        foreach ($preferences as $preference) {
            $result[$preference->id] = Holiday::whereHas('preferences', function ($query) use ($preference) {
                $query->where('preference_id', '=', $preference->id);
            })->pluck('title', 'id');
        }

        return $result;
    }

    /**
     * @return array
     */
    protected function getCookTimes()
    {
        $all = collect(CookTime::labels());
        $selected = $this->getSelected(Search::P_COOK_TIMES)->all();

        return [
            'key' => Search::P_COOK_TIMES,
            'all' => $all,
            'selected' => $all->filter(function ($value, $key) use ($selected) {
                return in_array($key, $selected);
            }),
            'title' => trans('recipes/list.cookTimes-title'),
            'multiple' => 1,
            'dependent' => 0
        ];
    }

    /**
     * @return array
     */
    protected function getChefs()
    {
        $selected = [];
        /** @var Collection $selectedIds */
        $selectedIds = $this->getSelected(Search::P_CHEFS);

        if ($selectedIds->count() > 0) {
            $objects = User::whereIn("id", $selectedIds)->get();
            $selected = $objects->pluck('fullName', 'id');
        }

        return [
            'key' => Search::P_CHEFS,
            'all' => [],
            'selected' => $selected,
            'title' => trans('recipes/list.chefs-title'),
            'multiple' => 1,
            'dependent' => 0,
            'ajaxUrl' => route('search.chefs') . '?w='
        ];
    }

    /**
     * @return array
     */
    protected function getSources()
    {
        $result = $this->resolveParametersWithAll(
            Source::class,
            Search::P_SOURCES,
            trans('recipes/list.sources-title')
        );
        $result['dependent'] = 0;

        return $result;
    }

    /**
     * @return array
     */
    protected function getCuisines()
    {
        $result = $this->resolveParametersWithAll(
            Cuisine::class,
            Search::P_CUISINES,
            trans('recipes/list.cuisines-title')
        );

        $preferences = $this->getAllPreferences();

        foreach ($preferences as $preference) {
            $result[$preference->id] = Cuisine::whereHas('preferences', function ($query) use ($preference) {
                $query->where('preference_id', '=', $preference->id);
            })->pluck('title', 'id');
        }

        return $result;
    }

    /**
     * @return array
     */
    protected function getBlessingTypes()
    {
        $result = $this->resolveParametersWithAll(
            BlessingType::class,
            Search::P_BLESSING_TYPES,
            trans('recipes/list.blessingTypes-title')
        );
        $result['dependent'] = 0;

        return $result;
    }

    /**
     * @return array
     */
    protected function getCategories()
    {
        $result = $this->resolveParametersWithAll(
            RecipeCategory::class,
            Search::P_CATEGORIES,
            trans('recipes/list.courses-title')
        );

        $result['dependent'] = 0;

        return $result;
    }

    /**
     * @return array
     */
    protected function getFeatured()
    {
        $all = [1 => trans('recipes/list.featured')];
        $selected = $this->getSelected(Search::P_FEATURED)->first();

        return [
            'key' => Search::P_FEATURED,
            'all' => $all,
            'selected' => ('on' == $selected) ? 1 : '',
            'label' => trans('recipes/list.featured'),
            'multiple' => 0,
            'dependent' => 0
        ];
    }

    /**
     * @return array
     */
    protected function getPageSize()
    {
        $res = $this->getSelected(Search::P_PAGESIZE)->first();
        $current = $res ?: config('kosher.pagination.recipes_list');
        $currentLink = \Request::url() . '?';
        $vars = \Request::all();
        unset($vars['page']);

        $links = collect(config('kosher.pagination.per_page_selector'))
            ->mapWithKeys(function ($item) use ($currentLink, $vars, $current) {
                $vars[Search::P_PAGESIZE] = $item;
                return [
                    [
                        'link' => $currentLink . http_build_query($vars),
                        'label' => $item,
                        'selected' => $current == $item
                    ]
                ];
            });

        return [
            'key' => Search::P_PAGESIZE,
            'selected' => $current,
            'all' => $links,
            'label' => trans('recipes/list.pager_size')
        ];
    }
}
