<?php

namespace App\Http\Controllers\Frontend\Search;

use App\Http\Controllers\Frontend\AbstractBaseSearch;
use App\Models\Video;
use App\Enums\VideoSorting;
use App\Enums\VideoOwners;
use App\Enums\WatchFilter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

/**
 * Class Watch
 * @package App\Http\Controllers\Frontend\Search
 */
class Watch extends AbstractBaseSearch
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
        $count = $this->getCountByKeyword($request->input(WatchFilter::P_KEYWORD));

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
        $this->parametersKeys = WatchFilter::labels();
        $this->singleParameters = [
            WatchFilter::P_PAGESIZE,
            WatchFilter::P_SORT,
            WatchFilter::P_KEYWORD,
            WatchFilter::P_OWNER_TYPE
        ];
    }

    /**
     * @param array $data
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    protected function render($data)
    {
        $data['labels'] = array_merge(trans('search/common'), trans('search/watch'));

        return view('search.watch.list', $data);
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
            'keyword' => $this->getKeyword(),
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
        $query = Video::published()->select(['videos.*']);
        $this->applyParametersToQuery($query);
        return $query->distinct();
    }

    /**
     * @return array
     */
    protected function getPageSize()
    {
        $res = $this->getSelected(WatchFilter::P_PAGESIZE)->first();
        $current = $res ?: config('kosher.pagination.recipes_list');
        $currentLink = \Request::url() . '?';
        $vars = \Request::all();
        unset($vars['page']);

        $links = collect(config('kosher.pagination.per_page_selector'))
            ->mapWithKeys(function ($item) use ($currentLink, $vars, $current) {
                $vars[WatchFilter::P_PAGESIZE] = $item;
                return [
                    [
                        'link' => $currentLink . http_build_query($vars),
                        'label' => $item,
                        'selected' => $current == $item
                    ]
                ];
            });

        return [
            'key' => WatchFilter::P_PAGESIZE,
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
            'key' => WatchFilter::P_KEYWORD,
            'selected' => $this->getSelected(WatchFilter::P_KEYWORD)->first(),
            'all' => []
        ];
    }

    /**
     * @param Builder $query
     */
    protected function applyQueryByKeyword(Builder &$query)
    {
        $value = $this->getSelected(WatchFilter::P_KEYWORD);

        if ($value->count() > 0) {
            $value = $value->first();

            $query->where(function ($query) use ($value) {
                $query->where('title', 'like', '%'.$value.'%');
                $query->orWhereHas('tags', function ($hasQuery) use ($value) {
                    $hasQuery->where('title', 'like', '%'.$value.'%');
                });
            });
        }
    }

    /**
     * @return array
     */
    protected function getOwnerType()
    {
        $selectedIds = $this->getSelected(WatchFilter::P_OWNER_TYPE);

        $selectedIds = $selectedIds->filter(function ($value, $key) {
            return is_numeric($value);
        });

        $selectedIds = $selectedIds->first();

        $values = array_values(VideoOwners::labels());
        return [
            'key' => WatchFilter::P_OWNER_TYPE,
            'all' => $values,
            'selected' => $selectedIds ? VideoOwners::label($selectedIds) : null,
            'label' => trans('search/watch.placeholders.all'),
            'multiple' => 0,
            'dependent' => 0
        ];
    }

    /**
     * @param Builder $query
     */
    protected function applyQueryByOwnerType(Builder &$query)
    {
        $value = $this->getSelected(WatchFilter::P_OWNER_TYPE);
        if ($value->count() > 0) {
            $index = $value->first();
            $values = array_keys(VideoOwners::labels());
            $value = $values[$index];
            $query->where('videos.owner_type', $value);
        }
    }

    /**
     * @return array
     */
    protected function getSort()
    {
        return [
            'key' => WatchFilter::P_SORT,
            'all' => VideoSorting::labels(),
            'selected' => $this->getSelected(WatchFilter::P_SORT)->flip()->keys()->first(),
            'label' => trans('search/watch.labels.sort_by')
        ];
    }

    /**
     * @param Builder $query
     */
    protected function applyQueryBySort(Builder &$query)
    {
        $selected = $this->getSelected(WatchFilter::P_SORT)->first();

        switch ($selected) {
            case VideoSorting::OLDEST:
                $query->orderBy('created_at', 'asc');
                break;
            case VideoSorting::RECENT:
            default:
                $query->orderBy('created_at', 'desc');
                break;
        }
    }

    /**
     * Return featured videos
     */
    protected function getFeaturedItems()
    {
        return Video::featured()
            ->random()
            ->take(config('kosher.pagination.search_no_results_videos'))
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
            'viewAll' => route('watch'),
            'postRequest' => route('contact') . '?inquiry_type=suggest-a-video'
        ]);
    }
}
