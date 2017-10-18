<?php

namespace App\Http\Controllers\Frontend\Community;

use App\Enums\CommunityDetailsFilter;
use App\Enums\CommunityDetailsSorting;
use App\Http\Controllers\Frontend\AbstractBaseSearch;
use Illuminate\Database\Eloquent\Builder;
use Assets;

/**
 * Class AbstractDetails
 * @package App\Http\Controllers\Frontend\Community
 */
abstract class AbstractDetails extends AbstractBaseSearch
{
    /**
     * @var mixed
     */
    protected $item;

    /**
     * Init function
     */
    protected function init()
    {
        parent::init();

        Assets::group('frontend')->addJs('user/profile/activity.js');
        $this->parametersKeys = CommunityDetailsFilter::labels();

        $this->singleParameters = [
            CommunityDetailsFilter::P_PAGESIZE,
            CommunityDetailsFilter::P_SORT,
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
        $selected = $this->getSelected(CommunityDetailsFilter::P_SORT)->flip()->keys()->first();
        if (empty($selected)) {
            $selected = CommunityDetailsSorting::RECENT;
        }

        return [
            'key' => CommunityDetailsFilter::P_SORT,
            'all' => CommunityDetailsSorting::labels(),
            'selected' => $selected,
            'label' => trans('user/profile.activity.sort_by')
        ];
    }

    /**
     * @param Builder $query
     */
    protected function applyQueryBySort(Builder &$query)
    {
        $selected = $this->getSelected(CommunityDetailsFilter::P_SORT)->first();

        switch ($selected) {
            case CommunityDetailsSorting::VOTES:
                $query->votes();
                break;
            case CommunityDetailsSorting::RECENT:
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
        $res = $this->getSelected(CommunityDetailsFilter::P_PAGESIZE)->first();
        $current = $res ?: config('kosher.pagination.recipes_list');
        $currentLink = \Request::url() . '?';
        $vars = \Request::all();
        unset($vars['page']);

        $links = collect(config('kosher.pagination.per_page_selector'))
            ->mapWithKeys(function ($item) use ($currentLink, $vars, $current) {
                $vars[CommunityDetailsFilter::P_PAGESIZE] = $item;
                return [
                    [
                        'link' => $currentLink . http_build_query($vars),
                        'label' => $item,
                        'selected' => $current == $item
                    ]
                ];
            });

        return [
            'key' => CommunityDetailsFilter::P_PAGESIZE,
            'selected' => $current,
            'all' => $links,
            'label' => trans('recipes/list.pager_size')
        ];
    }
}
