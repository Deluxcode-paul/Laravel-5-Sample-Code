<?php

namespace App\Http\Controllers\Frontend;

use App\Enums\Search;
use App\Http\Controllers\Controller;
use App\Http\Traits\Search as SearchTrait;
use App\Models\Preference;
use App\Models\Recipe;
use App\Models\User;
use DaveJamesMiller\Breadcrumbs\Facade as Breadcrumbs;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Request as RequestFacade;

/**
 * Class AbstractBaseSearch
 * @package App\Http\Controllers\Frontend
 */
abstract class AbstractBaseSearch extends Controller
{
    use SearchTrait;

    protected $parameters;
    protected $parametersKeys = [];
    protected $singleParameters = [];
    protected $preferences;
    protected $currentUser;
    protected $applyUserPreferences = false;

    /**
     * AbstractBaseSearch constructor.
     */
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            $this->currentUser = Auth::user();
            $this->init();
            return $next($request);
        });
    }

    /**
     * @param array $data
     * @return mixed
     */
    abstract protected function render($data);

    /**
     * @return mixed
     */
    abstract protected function getResult();

    /**
     * @return array
     */
    abstract protected function getPageSize();

    /**
     * Init
     */
    protected function init()
    {
        $this->parametersKeys = Search::labels();

        Paginator::currentPathResolver(function () {
            $vars = \Request::all();
            unset($vars['page']);
            return \Request::url() . '?' . http_build_query($vars);
        });
    }

    /**
     * @param Request $request
     */
    protected function readInputVars(Request $request)
    {
        foreach ($request->all() as $key => $values) {
            if (is_array($values)) {
                $this->parameters[$key] = in_array($key, $this->singleParameters)
                    ? $values
                    : array_keys($values);
            } else {
                if (in_array($key, $this->singleParameters) && strlen($values)) {
                    $this->parameters[$key] = $values;
                }
            }
        }
    }

    /**
     * Redirects to URL with user preferences applied
     *
     * @param User $user
     * @return \Illuminate\Http\RedirectResponse
     */
    protected function applyUserPreferences($user)
    {
        $arguments = Input::query();
        $currentRoute = \Request::route()->getName();

        if (!isset($this->parameters[Search::P_DIETS]) || empty($this->parameters[Search::P_DIETS])) {
            foreach ($user->diets()->getResults() as $diet) {
                $arguments[Search::P_DIETS][$diet->id] = 'on';
            }
        }

        if (!isset($this->parameters[Search::P_ALLERGENS]) || empty($this->parameters[Search::P_ALLERGENS])) {
            foreach ($user->allergens()->getResults() as $allergen) {
                $arguments[Search::P_ALLERGENS][$allergen->id] = 'on';
            }
        }

        $arguments[Search::P_SECONDARY] = 'on';

        return redirect()->route($currentRoute, $arguments);
    }

    /**
     * @return mixed
     */
    protected function calculatePageSize()
    {
        $pager = $this->getPageSize();

        return $pager['selected'];
    }

    /**
     * @return Collection
     */
    protected function calculateParameters()
    {
        $parameters = new Collection();

        foreach ($this->parametersKeys as $parameter => $methodName) {
            $method = 'get' . ucfirst($methodName);
            $parameters->put($methodName, method_exists($this, $method)
                ? $this->$method()
                : [
                    'key' => '',
                    'selected' => new Collection(),
                    'all' => new Collection(),
                    'label' => '',
                    'multiple' => 0,
                    'dependent' => 0
                ]);
        }

        return $parameters;
    }

    /**
     * @param $parameter
     * @return Collection
     */
    protected function getSelected($parameter)
    {
        $selected = isset($this->parameters[$parameter])
            ? $this->parameters[$parameter]
            : [];

        $selected = is_array($selected)
            ? $selected
            : [$selected];

        return collect($selected);
    }

    /**
     * Should exist methods with  name which starts from 'applyQueryBy'
     * @param mixed $query
     */
    protected function applyParametersToQuery(&$query)
    {
        foreach ($this->parametersKeys as $methodName) {
            $method = 'applyQueryBy' . ucfirst($methodName);
            if (method_exists($this, $method)) {
                $this->$method($query);
            }
        }
    }

    /**
     * @param $modelName
     * @param $parametersKey
     * @param $label
     * @return array
     */
    protected function resolveParameters($modelName, $parametersKey, $label)
    {
        $selected = new Collection();
        /** @var Collection $selectedIds */
        $selectedIds = $this->getSelected($parametersKey);
        $selectedIds = $selectedIds->filter(function ($value, $key) {
            return is_numeric($value);
        });

        if ($selectedIds->count() > 0) {
            $objects = call_user_func_array([$modelName, 'whereIn'], ["id", $selectedIds]);
            $selected = $objects->pluck('title', 'id');
        }

        return [
            'key' => $parametersKey,
            'all' => [],
            'selected' => $selected,
            'label' => $label,
            'multiple' => 1,
            'dependent' => 1
        ];
    }

    /**
     * @param $modelName
     * @param $parametersKey
     * @param $label
     * @return array
     */
    protected function resolveParametersWithAll($modelName, $parametersKey, $label)
    {
        $result = $this->resolveParameters($modelName, $parametersKey, $label);
        $all = call_user_func($modelName . '::all');
        $result['all'] = $all->pluck('title', 'id');

        return $result;
    }

    /**
     * @param mixed $query
     * @param \Illuminate\Support\Collection $parameters
     * @return string
     */
    protected function getResultsJsonData($query, $parameters)
    {
        $pageSize = $this->calculatePageSize();
        $pager = $this->getPager($query, $pageSize);
        $header = $parameters->pull('header');

        return json_encode([
            'header' => $header,
            'pageSize' => $parameters->pull('pageSize'),
            'sort' => $parameters->pull('sort'),
            'pager' => $pager,
            'items' => $query->get(),
            'parameters' => $parameters,
            'secondary' => Search::P_SECONDARY,
            'breadcrumbs' => Breadcrumbs::generate('recipes.subcategory', $header)
        ]);
    }

    /**
     * @return Collection|static[]
     */
    protected function getAllPreferences()
    {
        if (empty($this->preferences)) {
            $this->preferences = Preference::all();
        }

        return $this->preferences;
    }

    /**
     * Return featured recipes
     * @return Collection
     */
    protected function getFeaturedItems()
    {
        return Recipe::featured()
            ->inRandomOrder()
            ->take(config('kosher.pagination.search_no_results_recipes'))
            ->get();
    }

    /**
     * No Results JSON
     * @return string
     */
    protected function getNoResultsJson()
    {
        return json_encode([
            'itemsFeatured' => $this->getFeaturedItems(),
            'viewAll' => route('recipes.list').'?'.Search::P_FEATURED.'=on',
            'postRequest' => route('contact') . '?inquiry_type=suggest-a-recipe'
        ]);
    }

    /**
     * Get Search Tabs JSON
     * @param array $keyword
     * @param array $count
     * @return string
     */
    protected function getTabsJson($keyword, $count)
    {
        $currentRoute = RequestFacade::route()->getName();

        return json_encode([
            [
                'title' => trans('search/common.labels.recipes'),
                'url' => route('search.recipes').'?'.$keyword['key'].'='.$keyword['selected'],
                'count' => $count['recipes'],
                'isActive' => ('search.recipes' == $currentRoute)
            ],
            [
                'title' => trans('search/common.labels.lifestyle'),
                'url' => route('search.lifestyle').'?'.$keyword['key'].'='.$keyword['selected'],
                'count' => $count['lifestyle'],
                'isActive' => ('search.lifestyle' == $currentRoute)
            ],
            [
                'title' => trans('search/common.labels.chefs'),
                'url' => route('search.chef').'?'.$keyword['key'].'='.$keyword['selected'],
                'count' => $count['chefs'],
                'isActive' => ('search.chef' == $currentRoute)
            ],
            [
                'title' => trans('search/common.labels.watch'),
                'url' => route('search.watch').'?'.$keyword['key'].'='.$keyword['selected'],
                'count' => $count['watch'],
                'isActive' => ('search.watch' == $currentRoute)
            ],
        ]);
    }

    /**
     * @param mixed $query
     * @param mixed $pageSize
     * @return string
     */
    protected function getPager($query, $pageSize)
    {
        $pager = (string) $query->paginate($pageSize)->links('common/pagination');

        return $this->obfuscateHtml($pager);
    }

    /**
     * @param string $string
     * @return string
     */
    protected function obfuscateHtml($string)
    {
        $string = str_replace(array("\r\n", "\r"), "\n", $string);
        $lines = explode("\n", $string);
        $new_lines = array();

        foreach ($lines as $i => $line) {
            if (!empty($line)) {
                $new_lines[] = trim($line);
            }
        }

        return implode($new_lines);
    }
}
