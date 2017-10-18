<?php

namespace App\Http\Controllers\Frontend\User\Profile\Activity;

use App\Enums\ActivityFilter;
use App\Enums\ActivitySorting;
use App\Http\Controllers\Frontend\AbstractBaseSearch;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Assets;

/**
 * Class AbstractActivity
 * @package App\Http\Controllers\Frontend\User\Profile\Activity
 */
abstract class AbstractActivity extends AbstractBaseSearch
{
    /**
     * @param Request $request
     * @return mixed
     */
    public function __invoke(Request $request)
    {
        $this->readInputVars($request);
        $parameters = $this->calculateParameters();
        $result = $this->getResult();
        Assets::group('frontend')->addJs('user/profile/activity.js');

        return $this->render([
            'currentUrl' => \Request::url(),
            'results' => $this->getResultsJsonData($result, $parameters),
        ]);
    }

    /**
     * Init function
     */
    protected function init()
    {
        parent::init();

        $this->parametersKeys = ActivityFilter::labels();

        $this->singleParameters = [
            ActivityFilter::P_PAGESIZE,
            ActivityFilter::P_SORT,
        ];
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
        $items = $query->get();

        return json_encode([
            'pageSize' => $parameters->pull('pageSize'),
            'pager' => $pager,
            'items' => $items,
            'parameters' => $parameters
        ]);
    }

    /**
     * @return array
     */
    protected function getSort()
    {
        $selected = $this->getSelected(ActivityFilter::P_SORT)->flip()->keys()->first();
        if (empty($selected)) {
            $selected = ActivitySorting::RECENT;
        }

        return [
            'key' => ActivityFilter::P_SORT,
            'all' => ActivitySorting::labels(),
            'selected' => $selected,
            'label' => trans('user/profile.activity.sort_by')
        ];
    }

    /**
     * @param Builder $query
     */
    protected function applyQueryBySort(Builder &$query)
    {
        $selected = $this->getSelected(ActivityFilter::P_SORT)->first();

        switch ($selected) {
            case ActivitySorting::VIEWS:
                $query->popular();
                break;
            case ActivitySorting::RECENT:
            default:
                $query->recent();
                break;
        }
    }

    /**
     * @return array
     */
    protected function getPageSize()
    {
        $res = $this->getSelected(ActivityFilter::P_PAGESIZE)->first();
        $current = $res ?: config('kosher.pagination.recipes_list');
        $currentLink = \Request::url() . '?';
        $vars = \Request::all();
        unset($vars['page']);

        $links = collect(config('kosher.pagination.per_page_selector'))
            ->mapWithKeys(function ($item) use ($currentLink, $vars, $current) {
                $vars[ActivityFilter::P_PAGESIZE] = $item;
                return [
                    [
                        'link' => $currentLink . http_build_query($vars),
                        'label' => $item,
                        'selected' => $current == $item
                    ]
                ];
            });

        return [
            'key' => ActivityFilter::P_PAGESIZE,
            'selected' => $current,
            'all' => $links,
            'label' => trans('recipes/list.pager_size')
        ];
    }
}
