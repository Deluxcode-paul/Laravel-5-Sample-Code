<?php

namespace App\Http\Controllers\Frontend\Search;

use App\Enums\ChefsFilter;
use App\Enums\ChefSorting;
use App\Http\Controllers\Frontend\AbstractBaseSearch;
use App\Models\Country;
use App\Models\State;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Builder;
use App\Enums\UserRole;

/**
 * Class Chefs
 * @package App\Http\Controllers\Frontend\Search
 */
class Chefs extends AbstractBaseSearch
{
    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function __invoke(Request $request)
    {
        $this->readInputVars($request);
        $parameters = $this->calculateParameters();
        $result = $this->getResult();
        $keyword = $this->getKeyword();
        $count = $this->getCountByKeyword($request->input(ChefsFilter::P_KEYWORD));

        return $this->render([
            'currentUrl' => \Request::url(),
            'keyword' => $keyword,
            'count' => $count,
            'results' => $this->getResultsJsonData($result, $parameters),
            'noResults' => $this->getNoResultsJson(),
            'tabs' => $this->getTabsJson($keyword, $count)
        ]);
    }

    /**
     * Init function
     */
    protected function init()
    {
        parent::init();

        $this->parametersKeys = ChefsFilter::labels();

        $this->singleParameters = [
            ChefsFilter::P_PAGESIZE,
            ChefsFilter::P_SORT,
            ChefsFilter::P_KEYWORD,
            ChefsFilter::P_ROLE,
            ChefsFilter::P_STATE,
            ChefsFilter::P_COUNTRY,
        ];
    }

    /**
     * @param array $data
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    protected function render($data)
    {
        $data['labels'] = array_merge(trans('search/common'), trans('search/chefs'));

        return view('search.chefs.list', $data);
    }

    /**
     * @param mixed $query
     * @param \Illuminate\Support\Collection $parameters
     * @return string
     */
    protected function getResultsJsonData($query, $parameters)
    {
        $resultsCount = $query->get()->count();
        $pageSize = $this->calculatePageSize();
        $pager = $this->getPager($query, $pageSize);
        $items = $query->get();

        return json_encode([
            'keyword' => $parameters->pull('keyword'),
            'pageSize' => $parameters->pull('pageSize'),
            'sort' => $parameters->pull('sort'),
            'pager' => $pager,
            'items' => $items,
            'resultsCount' => $resultsCount,
            'parameters' => $parameters
        ]);
    }

    /**
     * @return mixed
     */
    protected function getResult()
    {
        /** @var Builder $query */
        $query = User::whereHas('roles', function ($hasQuery) {
            $hasQuery->whereIn('id', [
                UserRole::ROLE_COMMUNITY_CHEF,
                UserRole::ROLE_PROFESSIONAL_CHEF
            ]);
        })->select(['users.*']);
        $this->applyParametersToQuery($query);
        return $query->distinct();
    }

    /**
     * @return array
     */
    protected function getPageSize()
    {
        $res = $this->getSelected(ChefsFilter::P_PAGESIZE)->first();
        $current = $res ?: config('kosher.pagination.recipes_list');
        $currentLink = \Request::url() . '?';
        $vars = \Request::all();
        unset($vars['page']);

        $links = collect(config('kosher.pagination.per_page_selector'))
            ->mapWithKeys(function ($item) use ($currentLink, $vars, $current) {
                $vars[ChefsFilter::P_PAGESIZE] = $item;
                return [
                    [
                        'link' => $currentLink . http_build_query($vars),
                        'label' => $item,
                        'selected' => $current == $item
                    ]
                ];
            });

        return [
            'key' => ChefsFilter::P_PAGESIZE,
            'selected' => $current,
            'all' => $links,
            'label' => trans('recipes/list.pager_size')
        ];
    }

    /**
     * @return array
     */
    protected function getKeyword()
    {
        return [
            'key' => ChefsFilter::P_KEYWORD,
            'selected' => $this->getSelected(ChefsFilter::P_KEYWORD)->first(),
            'all' => []
        ];
    }

    /**
     * @return array
     */
    protected function getRole()
    {
        $result['key'] = ChefsFilter::P_ROLE;
        $result['all'] = [
            UserRole::ROLE_COMMUNITY_CHEF => UserRole::label(UserRole::ROLE_COMMUNITY_CHEF),
            UserRole::ROLE_PROFESSIONAL_CHEF => UserRole::label(UserRole::ROLE_PROFESSIONAL_CHEF)
        ];
        $result['multiple'] = 0;
        $result['dependent'] = 0;
        $result['selected'] = $this->getSelected(ChefsFilter::P_ROLE)->flip()->keys()->first();
        return $result;
    }

    /**
     * @return array
     */
    protected function getSort()
    {
        return [
            'key' => ChefsFilter::P_SORT,
            'all' => ChefSorting::labels(),
            'selected' => $this->getSelected(ChefsFilter::P_SORT)->flip()->keys()->first(),
            'label' => trans('search/lifestyle.labels.sort_by')
        ];
    }

    /**
     * @return array
     */
    protected function getState()
    {
        return $this->resolveParametersWithAll(
            State::class,
            ChefsFilter::P_STATE,
            trans('search/chefs.placeholders.state')
        );
    }

    /**
     * @return array
     */
    protected function getCountry()
    {
        $result = $this->resolveParameters(
            Country::class,
            ChefsFilter::P_COUNTRY,
            trans('search/chefs.placeholders.state')
        );
        $result['all'] = Country::join('users', 'countries.id', '=', 'users.country_id')
            ->join('role_users', 'users.id', '=', 'role_users.user_id')
            ->whereIn('role_users.role_id', [UserRole::ROLE_COMMUNITY_CHEF, UserRole::ROLE_PROFESSIONAL_CHEF])
            ->pluck('countries.title', 'countries.id');
        $result['multiple'] = 0;
        $result['dependent'] = 0;
        return $result;
    }

    /**
     * @param Builder $query
     */
    protected function applyQueryByKeyword(Builder &$query)
    {
        $value = $this->getSelected(ChefsFilter::P_KEYWORD);

        if ($value->count() > 0) {
            $value = $value->first();

            $query->where(function ($query) use ($value) {
                $query->where('first_name', 'like', '%'.$value.'%');
                $query->orWhere('last_name', 'like', '%'.$value.'%');
                $query->orWhere('name', 'like', '%'.$value.'%');
            });
        }
    }

    /**
     * @param Builder $query
     */
    protected function applyQueryBySort(Builder &$query)
    {
        $selected = $this->getSelected(ChefsFilter::P_SORT)->first();

        $fullName = DB::raw('CONCAT(users.first_name,\' \',users.last_name)');

        switch ($selected) {
            case ChefSorting::NAME_DESC:
                $query->orderBy($fullName, 'desc');
                break;
            case ChefSorting::NAME_ASC:
            default:
                $query->orderBy($fullName, 'asc');
                break;
        }
    }

    /**
     * @param Builder $query
     */
    protected function applyQueryByRole(Builder &$query)
    {
        $value = $this->getSelected(ChefsFilter::P_ROLE);
        if ($value->count() > 0) {
            $roleId = $value->first();
            $query->whereHas('roles', function ($q) use ($roleId) {
                $q->where('id', $roleId);
            });
        }
    }

    /**
     * @param Builder $query
     */
    protected function applyQueryByState(Builder &$query)
    {
        $value = $this->getSelected(ChefsFilter::P_STATE);
        if ($value->count() > 0) {
            $query->where('state_id', $value->first());
        }
    }

    /**
     * @param Builder $query
     */
    protected function applyQueryByCountry(Builder &$query)
    {
        $value = $this->getSelected(ChefsFilter::P_COUNTRY);
        if ($value->count() > 0) {
            $query->where('country_id', $value->first());
        }
    }

    /**
     * Return featured chefs
     */
    protected function getFeaturedItems()
    {
        return User::featured()
            ->random()
            ->take(config('kosher.pagination.search_no_results_chefs'))
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
            'viewAll' => route('about.chefs'),
            'postRequest' => route('contact') . '?inquiry_type=suggest-a-chef'
        ]);
    }
}
