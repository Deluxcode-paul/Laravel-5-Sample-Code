<?php

namespace App\Http\Controllers\Frontend\Search;

use App\Enums\Search;
use App\Http\Controllers\Frontend\AbstractRecipeSearch;
use App\Models\Ingredient;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/**
 * Class Recipes
 * @package App\Http\Controllers\Frontend\Search
 */
class Recipes extends AbstractRecipeSearch
{
    protected $applyUserPreferences = true;

    /**
     * @param Request $request
     * @return mixed
     */
    public function __invoke(Request $request)
    {
        $this->readInputVars($request);
        $user = Auth::user();
        if (empty($request->get(Search::P_SECONDARY)) && $user) {
            return $this->applyUserPreferences($user);
        }

        $parameters = $this->calculateParameters();
        $result = $this->getResult();
        $keyword = $this->getKeyword();
        $count = $this->getCountByKeyword($request->input(Search::P_KEYWORD));

        return $this->render([
            'currentUrl' => \Request::url(),
            'keyword' => $keyword,
            'count' => $count,
            'results' => $this->getResultsJsonData($result, $parameters),
            'noResults' => $this->getNoResultsJson(),
            'tabs' => $this->getTabsJson($keyword, $count),
            'ingredients' => Ingredient::all()->pluck('title', 'id')
        ]);
    }

    /**
     * Init function
     */
    protected function init()
    {
        parent::init();

        $this->singleParameters[] = Search::P_KEYWORD;

        if (isset($this->parametersKeys[Search::P_HEADER])) {
            unset($this->parametersKeys[Search::P_HEADER]);
        }
    }

    /**
     * @param array $data
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    protected function render($data)
    {
        $data['labels'] = array_merge(trans('search/common'), trans('search/recipes'));

        return view('search.recipes.list', $data);
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
            'parameters' => $parameters,
            'secondary' => Search::P_SECONDARY
        ]);
    }

    /**
     * @param Builder $query
     */
    protected function applyQueryByKeyword(Builder &$query)
    {
        $value = $this->getSelected(Search::P_KEYWORD);

        if ($value->count() > 0) {
            $value = $value->first();

            $query->where(function ($query) use ($value) {
                $query->where('title', 'like', '%' . $value . '%');
                $query->orWhereHas('tags', function ($hasQuery) use ($value) {
                    $hasQuery->where('title', 'like', '%' . $value . '%');
                });
                $query->orWhereHas('preference', function ($hasQuery) use ($value) {
                    $hasQuery->where('title', 'like', '%' . $value . '%');
                });
                $query->orWhereHas('allergens', function ($hasQuery) use ($value) {
                    $hasQuery->where('title', 'like', '%' . $value . '%');
                });
                $query->orWhereHas('ingredients', function ($hasQuery) use ($value) {
                    $hasQuery->where('description', 'like', '%' . $value . '%');
                });
                $query->orWhereHas('sources', function ($hasQuery) use ($value) {
                    $hasQuery->where('title', 'like', '%' . $value . '%');
                });
                $query->orWhereHas('categories', function ($hasQuery) use ($value) {
                    $hasQuery->where('title', 'like', '%' . $value . '%');
                });
                $query->orWhereHas('cuisines', function ($hasQuery) use ($value) {
                    $hasQuery->where('title', 'like', '%' . $value . '%');
                });
                $query->orWhereHas('user', function ($hasQuery) use ($value) {
                    $hasQuery->where('first_name', 'like', '%' . $value . '%');
                    $hasQuery->orWhere('last_name', 'like', '%' . $value . '%');
                    $hasQuery->orWhere('name', 'like', '%' . $value . '%');
                });
                $query->orWhereHas('holidays', function ($hasQuery) use ($value) {
                    $hasQuery->where('title', 'like', '%' . $value . '%');
                });
                $query->orWhereHas('diets', function ($hasQuery) use ($value) {
                    $hasQuery->where('title', 'like', '%' . $value . '%');
                });
                $query->orWhereHas('blessingType', function ($hasQuery) use ($value) {
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
            'key' => Search::P_KEYWORD,
            'selected' => $this->getSelected(Search::P_KEYWORD)->first(),
            'all' => []
        ];
    }
}
