<?php

namespace App\Http\Controllers\Frontend\User\Profile\MyArticles;

use App\Enums\MyArticlesFilter;
use App\Http\Controllers\Frontend\AbstractBaseSearch;
use App\Models\Article;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

/**
 * Class View
 * @package App\Http\Controllers\Frontend\User\Profile\MyArticles
 */
class View extends AbstractBaseSearch
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

        return $this->render([
            'currentUrl' => \Request::url(),
            'results' => $this->getResultsJsonData($result, $parameters),
            'noResults' => $this->getNoResultsJson()
        ]);
    }

    /**
     * Init function
     */
    protected function init()
    {
        parent::init();

        $this->parametersKeys = MyArticlesFilter::labels();

        $this->singleParameters = [
            MyArticlesFilter::P_PAGESIZE
        ];
    }

    /**
     * @param array $data
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    protected function render($data)
    {
        $data['labels'] = array_merge(trans('search/common'), trans('user/profile'));

        return view('user.profile.my_articles', $data);
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
     * @return mixed
     */
    protected function getResult()
    {
        /** @var Builder $query */
        $query = Article::select(['articles.*'])->where('user_id', $this->currentUser->id);
        $query->orderBy('updated_at', 'desc');
        $this->applyParametersToQuery($query);

        return $query->distinct();
    }

    /**
     * @return array
     */
    protected function getPageSize()
    {
        $res = $this->getSelected(MyArticlesFilter::P_PAGESIZE)->first();
        $current = $res ?: config('kosher.pagination.recipes_list');
        $currentLink = \Request::url() . '?';
        $vars = \Request::all();
        unset($vars['page']);

        $links = collect(config('kosher.pagination.per_page_selector'))
            ->mapWithKeys(function ($item) use ($currentLink, $vars, $current) {
                $vars[MyArticlesFilter::P_PAGESIZE] = $item;
                return [
                    [
                        'link' => $currentLink . http_build_query($vars),
                        'label' => $item,
                        'selected' => $current == $item
                    ]
                ];
            });

        return [
            'key' => MyArticlesFilter::P_PAGESIZE,
            'selected' => $current,
            'all' => $links,
            'label' => trans('recipes/list.pager_size')
        ];
    }
}
