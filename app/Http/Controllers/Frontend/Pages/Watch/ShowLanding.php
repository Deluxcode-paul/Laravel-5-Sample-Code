<?php

namespace App\Http\Controllers\Frontend\Pages\Watch;

use App\Http\Controllers\Frontend\AbstractBaseSearch;
use App\Models\Show;
use App\Models\Video;
use App\Enums\VideoSorting;
use App\Enums\WatchFilter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Assets;

/**
 * Class ShowLanding
 * @package App\Http\Controllers\Frontend\Pages\Watch
 */
class ShowLanding extends AbstractBaseSearch
{
    protected $show;

    /**
     * @param Request $request
     * @param Show $show
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function __invoke(Request $request, Show $show)
    {
        $this->show = $show;
        $this->readInputVars($request);
        $parameters = $this->calculateParameters();
        $result = $this->getResult();

        return $this->render([
            'results' => $this->getResultsJsonData($result, $parameters),
            'noResults' => $this->getNoResultsJson(),
            'show' => $show,
            'showChefs' => $show->chefs()->get()
        ]);
    }

    /**
     * Init function
     */
    protected function init()
    {
        parent::init();

        $this->parametersKeys = WatchFilter::labels();

        unset($this->parametersKeys[WatchFilter::P_KEYWORD]);
        unset($this->parametersKeys[WatchFilter::P_OWNER_TYPE]);

        $this->singleParameters = [
            WatchFilter::P_PAGESIZE,
            WatchFilter::P_SORT
        ];
    }

    /**
     * @param array $data
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    protected function render($data)
    {
        Assets::group('frontend')->addJs('pages/show.js');
        $data['labels'] = array_merge(trans('search/common'), trans('search/watch'), trans('pages/show'));

        return view('pages.watch.show', $data);
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
            'sort' => $parameters->pull('sort'),
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
        $query = Video::published()
            ->where('owner_id', $this->show->id)
            ->where('owner_type', get_class($this->show))
            ->select(['videos.*']);
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
