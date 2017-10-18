<?php

namespace App\Http\Controllers\Frontend\Pages;

use App\Enums\CookTime;
use App\Enums\GenerateMealFilter;
use App\Http\Controllers\Frontend\AbstractBaseSearch;
use App\Models\Ingredient;
use App\Models\Recipe;
use App\Models\RecipeCategory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

/**
 * Class GenerateMeal
 * @package App\Http\Controllers\Frontend\Pages
 */
class GenerateMeal extends AbstractBaseSearch
{
    protected $applyUserPreferences = false;

    /**
     * @param Request $request
     * @return mixed
     */
    public function __invoke(Request $request)
    {
        $this->readInputVars($request);
        $parameters = $this->calculateParameters();
        if (empty($this->parameters)) {
            $result = null;
        } else {
            $result = $this->getResult();
        }

        return $this->render([
            'currentUrl' => \Request::url(),
            'results' => $this->getResultsJsonData($result, $parameters),
            'noResults' => $this->getNoResultsJson(),
            'ingredients' => Ingredient::all()->pluck('title', 'id')
        ]);
    }

    /**
     * Init function
     */
    protected function init()
    {
        parent::init();

        $this->parametersKeys = GenerateMealFilter::labels();

        $this->singleParameters = [
            GenerateMealFilter::P_CATEGORY,
            GenerateMealFilter::P_PAGESIZE,
            GenerateMealFilter::P_COOK_TIME,
            GenerateMealFilter::P_INGREDIENTS,
        ];
    }

    /**
     * @param array $data
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    protected function render($data)
    {
        $data['labels'] = trans('pages/generate_meal');

        return view('pages.generate_meal', $data);
    }

    /**
     * @param mixed $query
     * @param \Illuminate\Support\Collection $parameters
     * @return string
     */
    protected function getResultsJsonData($query, $parameters)
    {
        if (empty($query)) {
            $pager = '';
            $items = [];
        } else {
            $pageSize = $this->calculatePageSize();
            $pager = $this->getPager($query, $pageSize);
            $items = $query->get();
        }

        return json_encode([
            'pageSize' => $parameters->pull('pageSize'),
            'pager' => $pager,
            'items' => $items,
            'parameters' => $parameters
        ]);
    }

    /**
     * @return mixed
     */
    protected function getResult()
    {
        /** @var Builder $query */
        $query = Recipe::published()->with('user')->select(['recipes.*']);
        $query->orderBy('updated_at', 'desc');
        $this->applyParametersToQuery($query);

        return $query->distinct();
    }

    /**
     * @return array
     */
    protected function getPageSize()
    {
        $res = $this->getSelected(GenerateMealFilter::P_PAGESIZE)->first();
        $current = $res ?: config('kosher.pagination.recipes_list');
        $currentLink = \Request::url() . '?';
        $vars = \Request::all();
        unset($vars['page']);

        $links = collect(config('kosher.pagination.per_page_selector'))
            ->mapWithKeys(function ($item) use ($currentLink, $vars, $current) {
                $vars[GenerateMealFilter::P_PAGESIZE] = $item;
                return [
                    [
                        'link' => $currentLink . http_build_query($vars),
                        'label' => $item,
                        'selected' => $current == $item
                    ]
                ];
            });

        return [
            'key' => GenerateMealFilter::P_PAGESIZE,
            'selected' => $current,
            'all' => $links,
            'label' => trans('recipes/list.pager_size')
        ];
    }

    /**
     * @return array
     */
    protected function getCategory()
    {
        $result = $this->resolveParametersWithAll(
            RecipeCategory::class,
            GenerateMealFilter::P_CATEGORY,
            trans('pages/generate_meal.placeholders.categories')
        );

        $result['multiple'] = 0;
        $result['dependent'] = 0;

        return $result;
    }

    /**
     * @param Builder $query
     */
    protected function applyQueryByCategory(Builder &$query)
    {
        $value = $this->getSelected(GenerateMealFilter::P_CATEGORY);

        if ($value->count() > 0) {
            $value = $value->first();
            $query->whereHas('categories', function ($hasQuery) use ($value) {
                $hasQuery->where('recipe_categories.id', $value);
            });
        }
    }

    /**
     * @return array
     */
    protected function getCookTime()
    {
        $all = collect(CookTime::labels());
        $selected = $this->getSelected(GenerateMealFilter::P_COOK_TIME)->first();

        return [
            'key' => GenerateMealFilter::P_COOK_TIME,
            'all' => $all,
            'selected' => $all->filter(function ($value, $key) use ($selected) {
                return $key == $selected;
            }),
            'label' => trans('pages/generate_meal.placeholders.time'),
            'multiple' => 0,
            'dependent' => 0
        ];
    }

    /**
     * @param Builder $query
     */
    protected function applyQueryByCookTime(Builder &$query)
    {
        $value = $this->getSelected(GenerateMealFilter::P_COOK_TIME);
        if ($value->count() > 0) {
            $value = $value->first();
            switch ($value) {
                case CookTime::QUICK:
                    $query->where('cook_time', '<', CookTime::TIME_LIMIT_QUICK);
                    break;
                case CookTime::MEDIUM:
                    $query->where('cook_time', '>=', CookTime::TIME_LIMIT_QUICK);
                    $query->where('cook_time', '<', CookTime::TIME_LIMIT_MEDIUM);
                    break;
                case CookTime::LONG:
                    $query->where('cook_time', '>=', CookTime::TIME_LIMIT_MEDIUM);
                    $query->where('cook_time', '<', CookTime::TIME_LIMIT_LONG);
                    break;
                case CookTime::LONGER:
                default:
                    $query->where('cook_time', '>=', CookTime::TIME_LIMIT_LONGER);
                    break;
            }
        }
    }

    /**
     * @return array
     */
    protected function getIngredients()
    {
        return [
            'key' => GenerateMealFilter::P_INGREDIENTS,
            'all' => [],
            'selected' => $this->getSelected(GenerateMealFilter::P_INGREDIENTS),
            'label' => trans('pages/generate_meal.placeholders.ingredient'),
            'multiple' => 1,
            'dependent' => 0
        ];
    }

    /**
     * @param Builder $query
     */
    protected function applyQueryByIngredients(Builder &$query)
    {
        $values = $this->getSelected(GenerateMealFilter::P_INGREDIENTS);
        if ($values->count() > 0) {
            foreach ($values as $value) {
                $query->whereHas('ingredients', function ($hasQuery) use ($value) {
                    $hasQuery->where('ingredients.id', $value);
                });
            }
        }
    }

    /**
     * Return featured articles
     */
    protected function getFeaturedItems()
    {
        return Recipe::featured()
            ->inRandomOrder()
            ->take(config('kosher.pagination.generate_meal_no_results'))
            ->get();
    }
}
