<?php

namespace App\Http\Controllers\Frontend\User\Profile\RecipeBox;

use App\Enums\RecipeBoxFilter;
use App\Http\Controllers\Frontend\AbstractBaseSearch;
use App\Models\RecipeBox;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

/**
 * Class View
 * @package App\Http\Controllers\Frontend\User\Profile\RecipeBox
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
        $keyword = $this->getKeyword();

        return $this->render([
            'currentUrl' => \Request::url(),
            'results' => $this->getResultsJsonData($result, $parameters),
            'keyword' => $keyword
        ]);
    }

    /**
     * Init function
     */
    protected function init()
    {
        parent::init();

        $this->parametersKeys = RecipeBoxFilter::labels();

        $this->singleParameters = [
            RecipeBoxFilter::P_KEYWORD,
            RecipeBoxFilter::P_PAGESIZE
        ];
    }

    /**
     * @param array $data
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    protected function render($data)
    {
        $data['labels'] = array_merge(trans('search/common'), trans('user/profile'));

        return view('user.profile.recipe_box', $data);
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
        $userId = $this->currentUser->id;
        /** @var Builder $query */
        $query = RecipeBox::select(['recipe_boxes.*'])->where('user_id', $userId);
        $query->orderBy('updated_at', 'desc');
        $this->applyParametersToQuery($query);

        return $query->distinct();
    }

    /**
     * @return array
     */
    protected function getPageSize()
    {
        $res = $this->getSelected(RecipeBoxFilter::P_PAGESIZE)->first();
        $current = $res ?: config('kosher.pagination.recipes_list');
        $currentLink = \Request::url() . '?';
        $vars = \Request::all();
        unset($vars['page']);

        $links = collect(config('kosher.pagination.per_page_selector'))
            ->mapWithKeys(function ($item) use ($currentLink, $vars, $current) {
                $vars[RecipeBoxFilter::P_PAGESIZE] = $item;
                return [
                    [
                        'link' => $currentLink . http_build_query($vars),
                        'label' => $item,
                        'selected' => $current == $item
                    ]
                ];
            });

        return [
            'key' => RecipeBoxFilter::P_PAGESIZE,
            'selected' => $current,
            'all' => $links,
            'label' => trans('recipes/list.pager_size')
        ];
    }

    /**
     * @param Builder $query
     */
    protected function applyQueryByKeyword(Builder &$query)
    {
        $value = $this->getSelected(RecipeBoxFilter::P_KEYWORD);

        if ($value->count() > 0) {
            $value = $value->first();

            $query->where(function ($query) use ($value) {
                $query->whereHas('recipe', function ($hasQuery) use ($value) {
                    $hasQuery->where('title', 'like', '%' . $value . '%');
                });
                $query->orWhereHas('recipe.tags', function ($hasQuery) use ($value) {
                    $hasQuery->where('title', 'like', '%' . $value . '%');
                });
            });
        }
    }

    /**
     * @return array
     */
    protected function getKeyword()
    {
        return [
            'key' => RecipeBoxFilter::P_KEYWORD,
            'selected' => $this->getSelected(RecipeBoxFilter::P_KEYWORD)->first(),
            'all' => []
        ];
    }
}
