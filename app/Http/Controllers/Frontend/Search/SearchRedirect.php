<?php

namespace App\Http\Controllers\Frontend\Search;

use App\Enums\ArticleFilter;
use App\Enums\ChefsFilter;
use App\Enums\Search;
use App\Enums\WatchFilter;
use App\Http\Controllers\Controller;
use App\Http\Traits\Search as SearchTrait;
use Illuminate\Http\Request;

/**
 * Class SearchRedirect
 * @package App\Http\Controllers\Frontend\Search
 */
class SearchRedirect extends Controller
{
    use SearchTrait;

    /**
     * @var array
     */
    protected $tabs = [
        'recipes' => [
            'count' => 'getRecipesCountByKeyword',
            'route' => 'search.recipes',
            'attribute' => Search::P_KEYWORD
        ],
        'lifestyle' => [
            'count' => 'getArticlesCountByKeyword',
            'route' => 'search.lifestyle',
            'attribute' => ArticleFilter::P_KEYWORD
        ],
        'chefs' => [
            'count' => 'getChefsCountByKeyword',
            'route' => 'search.chef',
            'attribute' => ChefsFilter::P_KEYWORD
        ],
        'watch' => [
            'count' => 'getVideosCountByKeyword',
            'route' => 'search.watch',
            'attribute' => WatchFilter::P_KEYWORD
        ]
    ];

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function __invoke(Request $request)
    {
        $keyword = $request->input(Search::P_KEYWORD);

        foreach ($this->tabs as $tab) {
            $count = call_user_func([$this, $tab['count']], $keyword);
            if ($count > 0) {
                return $this->redirect($tab['route'], $tab['attribute'], $keyword);
            }
        }

        return $this->redirect($this->tabs['recipes']['route'], $this->tabs['recipes']['attribute'], $keyword);
    }

    /**
     * @param string $route
     * @param string $attribute
     * @param string $keyword
     * @return \Illuminate\Http\RedirectResponse
     */
    private function redirect($route, $attribute, $keyword)
    {
        return redirect()->to(route($route) . '?' . $attribute . '=' . $keyword);
    }
}
