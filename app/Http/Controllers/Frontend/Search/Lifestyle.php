<?php

namespace App\Http\Controllers\Frontend\Search;

use App\Enums\ArticleFilter;
use App\Enums\ArticleSorting;
use App\Enums\Month;
use App\Http\Controllers\Frontend\AbstractBaseSearch;
use App\Models\Article;
use App\Models\ArticleCategory;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

/**
 * Class Lifestyle
 * @package App\Http\Controllers\Frontend\Search
 */
class Lifestyle extends AbstractBaseSearch
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
        $keyword = $this->getKeyword();
        $count = $this->getCountByKeyword($request->input(ArticleFilter::P_KEYWORD));

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

        $this->parametersKeys = ArticleFilter::labels();

        $this->singleParameters = [
            ArticleFilter::P_KEYWORD,
            ArticleFilter::P_CATEGORY,
            ArticleFilter::P_YEAR,
            ArticleFilter::P_MONTH,
            ArticleFilter::P_PAGESIZE,
            ArticleFilter::P_SORT
        ];
    }

    /**
     * @param array $data
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    protected function render($data)
    {
        $data['labels'] = array_merge(trans('search/common'), trans('search/lifestyle'));

        return view('search.lifestyle.list', $data);
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
        $query = Article::published()->with('user')->select(['articles.*']);
        $this->applyParametersToQuery($query);

        return $query->distinct();
    }

    /**
     * @return array
     */
    protected function getPageSize()
    {
        $res = $this->getSelected(ArticleFilter::P_PAGESIZE)->first();
        $current = $res ?: config('kosher.pagination.recipes_list');
        $currentLink = \Request::url() . '?';
        $vars = \Request::all();
        unset($vars['page']);

        $links = collect(config('kosher.pagination.per_page_selector'))
            ->mapWithKeys(function ($item) use ($currentLink, $vars, $current) {
                $vars[ArticleFilter::P_PAGESIZE] = $item;
                return [
                    [
                        'link' => $currentLink . http_build_query($vars),
                        'label' => $item,
                        'selected' => $current == $item
                    ]
                ];
            });

        return [
            'key' => ArticleFilter::P_PAGESIZE,
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
            'key' => ArticleFilter::P_KEYWORD,
            'selected' => $this->getSelected(ArticleFilter::P_KEYWORD)->first(),
            'all' => []
        ];
    }

    /**
     * @param Builder $query
     */
    protected function applyQueryByKeyword(Builder &$query)
    {
        $value = $this->getSelected(ArticleFilter::P_KEYWORD);

        if ($value->count() > 0) {
            $value = $value->first();

            $query->where(function ($query) use ($value) {
                $query->where('title', 'like', '%'.$value.'%');
                $query->orWhereHas('tags', function ($hasQuery) use ($value) {
                    $hasQuery->where('title', 'like', '%'.$value.'%');
                });
                $query->orWhereHas('category', function ($hasQuery) use ($value) {
                    $hasQuery->where('title', 'like', '%'.$value.'%');
                });
            });
        }
    }

    /**
     * @return array
     */
    protected function getCategory()
    {
        $result = $this->resolveParametersWithAll(
            ArticleCategory::class,
            ArticleFilter::P_CATEGORY,
            trans('search/lifestyle.placeholders.categories')
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
        $value = $this->getSelected(ArticleFilter::P_CATEGORY);

        if ($value->count() > 0) {
            $value = $value->first();
            $query->where('articles.category_id', $value);
        }
    }

    /**
     * @return array
     */
    protected function getYear()
    {
        $years = collect();
        $minDate = Article::min('published_at');
        $maxDate = Article::max('published_at');
        $minYear = Carbon::createFromFormat(config('database.datetime_format'), $minDate)->year;
        $maxYear = Carbon::createFromFormat(config('database.datetime_format'), $maxDate)->year;

        for ($year = $maxYear; $year >= $minYear; $year--) {
            $years->put($year, $year);
        }

        $selected = $this->getSelected(ArticleFilter::P_YEAR)->first();

        return [
            'key' => ArticleFilter::P_YEAR,
            'all' => $years,
            'selected' => $years->filter(function ($value, $key) use ($selected) {
                return $key == $selected;
            }),
            'label' => trans('search/lifestyle.placeholders.year'),
            'multiple' => 0,
            'dependent' => 0
        ];
    }

    /**
     * @param Builder $query
     */
    protected function applyQueryByYear(Builder &$query)
    {
        $value = $this->getSelected(ArticleFilter::P_YEAR);

        if ($value->count() > 0) {
            $value = $value->first();
            $query->whereYear('articles.published_at', $value);
        }
    }

    /**
     * @return array
     */
    protected function getMonth()
    {
        $months = collect(Month::labels());
        $selected = $this->getSelected(ArticleFilter::P_MONTH)->first();

        return [
            'key' => ArticleFilter::P_MONTH,
            'all' => $months,
            'selected' => $months->filter(function ($value, $key) use ($selected) {
                return $key == $selected;
            }),
            'label' => trans('search/lifestyle.placeholders.month'),
            'multiple' => 0,
            'dependent' => 0
        ];
    }

    /**
     * @param Builder $query
     */
    protected function applyQueryByMonth(Builder &$query)
    {
        $value = $this->getSelected(ArticleFilter::P_MONTH);

        if ($value->count() > 0) {
            $value = $value->first();
            $query->whereMonth('articles.published_at', $value);
        }
    }

    /**
     * @return array
     */
    protected function getSort()
    {
        return [
            'key' => ArticleFilter::P_SORT,
            'all' => ArticleSorting::labels(),
            'selected' => $this->getSelected(ArticleFilter::P_SORT)->flip()->keys()->first(),
            'label' => trans('search/lifestyle.labels.sort_by')
        ];
    }

    /**
     * @param Builder $query
     */
    protected function applyQueryBySort(Builder &$query)
    {
        $selected = $this->getSelected(ArticleFilter::P_SORT)->first();

        switch ($selected) {
            case ArticleSorting::POPULAR:
                $query->mostPopular();
                break;
            case ArticleSorting::SHARED:
                $query->mostShared();
                break;
            case ArticleSorting::TITLE_ASC:
                $query->orderBy('title', 'asc');
                break;
            case ArticleSorting::TITLE_DESC:
                $query->orderBy('title', 'desc');
                break;
            case ArticleSorting::RECENT:
            default:
                $query->orderBy('published_at', 'desc');
                break;
        }
    }

    /**
     * Return featured articles
     */
    protected function getFeaturedItems()
    {
        return Article::published()
            ->featured()
            ->inRandomOrder()
            ->take(config('kosher.pagination.search_no_results_articles'))
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
            'viewAll' => route('lifestyle'),
            'postRequest' => route('contact') . '?inquiry_type=suggest-an-article'
        ]);
    }
}
