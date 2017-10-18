<?php

namespace App\Http\Controllers\Frontend\Pages;

use App\Enums\CommunityFilter;
use App\Enums\CommunitySearchSorting;
use App\Enums\CommunitySearchTypes;
use App\Enums\CommunityType;
use App\Http\Controllers\Frontend\AbstractBaseSearch;
use App\Models\ArticleComment;
use App\Models\GeneralQuestion;
use App\Models\RecipeQuestion;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;

/**
 * Class Community
 * @package App\Http\Controllers\Frontend\Pages
 */
class Community extends AbstractBaseSearch
{
    /**
     * @var Request
     */
    protected $request;

    /**
     * @var integer
     */
    protected $currentPage = 1;

    /**
     * @var array
     */
    protected $communityQueries = [];

    /**
     * @param Request $request
     * @return mixed
     */
    public function __invoke(Request $request)
    {
        $this->request = $request;
        $this->currentPage = LengthAwarePaginator::resolveCurrentPage();
        $this->readInputVars($request);
        $parameters = $this->calculateParameters();
        $result = $this->getResult();
        $keyword = $this->getKeyword();

        return $this->render([
            'keyword' => $keyword,
            'results' => $this->getResultsJsonData($result, $parameters),
        ]);
    }

    /**
     * Init function
     */
    protected function init()
    {
        parent::init();

        $this->parametersKeys = CommunityFilter::labels();

        $this->singleParameters = [
            CommunityFilter::P_KEYWORD,
            CommunityFilter::P_TYPE,
            CommunityFilter::P_PAGESIZE,
            CommunityFilter::P_SORT
        ];
    }

    /**
     * TODO: add popular tags and popular items to $data
     * @param array $data
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    protected function render($data)
    {
        $data['labels'] = array_merge(trans('search/common'), trans('community'));
        $popularItems = $this->getPopularItems();
        $data['popularItems'] = $this->getItems($popularItems);
        $data['popularTags'] = $this->getPopularTags($data['popularItems']);

        return view('community.landing', $data);
    }

    /**
     * @param mixed $query
     * @param \Illuminate\Support\Collection $parameters
     * @return string
     */
    protected function getResultsJsonData($query, $parameters)
    {
        $pageSize = $this->calculatePageSize();
        $items = $query->get();
        $totalCount = $items->count();
        $itemsForPage = $items->forPage($this->currentPage, $pageSize);
        $paginator = new LengthAwarePaginator($itemsForPage, $totalCount, $pageSize, $this->currentPage);
        $paginator->setPath(route('community'));
        $paginator->appends($this->request->except('page'));
        $pager = $this->obfuscateHtml($paginator->links('common/pagination'));
        $items = $this->getItems($itemsForPage);

        return json_encode([
            'pageSize' => $parameters->pull('pageSize'),
            'sort' => $parameters->pull('sort'),
            'pager' => $pager,
            'items' => $items,
            'parameters' => $parameters,
            'resultsCount' => $totalCount
        ]);
    }

    /**
     * @param mixed $query
     * @param mixed $pageSize
     * @return string
     */
    protected function getPager($query, $pageSize)
    {
        $items = $query->get();
        $pager = new LengthAwarePaginator(
            $items->forPage($this->currentPage, $pageSize),
            $items->count(),
            $pageSize,
            $this->currentPage
        );
        $pager->setPath('/' . $this->request->path());

        return $this->obfuscateHtml($pager->links('common/pagination'));
    }

    /**
     * @return mixed
     */
    protected function getResult()
    {
        $this->initCommunityQueries();
        $query = $this->getQueryByType();
        $this->applyParametersToQuery($query);

        return $query;
    }

    /**
     * Init queries
     */
    protected function initCommunityQueries()
    {
        unset($this->parametersKeys[CommunityFilter::P_KEYWORD]);
        $keyword = $this->getSelected(CommunityFilter::P_KEYWORD)->first();

        $this->communityQueries['recipeReviews'] = DB::table('reviews')->select(
            'reviews.id',
            'reviews.updated_at',
            'reviews.activity_month',
            'reviews.activity_year',
            'reviews.comments as replies',
            DB::raw('"'.CommunityType::RECIPE_REVIEW.'" as type')
        );

        if ($keyword) {
            $this->communityQueries['recipeReviews']->whereRaw('`title` like "%'.$keyword.'%"')
                ->orWhereRaw('exists
                    (select * from `tags` 
                    inner join `review_has_tag` on `tags`.`id` = `review_has_tag`.`tag_id` 
                    where `review_has_tag`.`review_id` = `reviews`.`id` 
                    and `title` like "%'.$keyword.'%")');
        }

        $this->communityQueries['recipeQuestions'] = DB::table('recipe_questions')->select(
            'recipe_questions.id',
            'recipe_questions.updated_at',
            'recipe_questions.activity_month',
            'recipe_questions.activity_year',
            'recipe_questions.answers as replies',
            DB::raw('"'.CommunityType::RECIPE_QUESTION.'" as type')
        );

        if ($keyword) {
            $this->communityQueries['recipeQuestions']->whereRaw('`title` like "%'.$keyword.'%"')
                ->orWhereRaw('exists
                    (select * from `tags` 
                    inner join `recipe_question_has_tag` on `tags`.`id` = `recipe_question_has_tag`.`tag_id` 
                    where `recipe_question_has_tag`.`recipe_question_id` = `recipe_questions`.`id` 
                    and `title` like "%'.$keyword.'%")');
        }

        $this->communityQueries['articleComments'] = DB::table('article_comments')->select(
            'article_comments.id',
            'article_comments.updated_at',
            'article_comments.activity_month',
            'article_comments.activity_year',
            'article_comments.replies',
            DB::raw('"'.CommunityType::ARTICLE_COMMENT.'" as type')
        );

        if ($keyword) {
            $this->communityQueries['articleComments']->whereRaw('`title` like "%'.$keyword.'%"')
                ->orWhereRaw('exists
                    (select * from `tags` 
                    inner join `article_comment_has_tag` on `tags`.`id` = `article_comment_has_tag`.`tag_id` 
                    where `article_comment_has_tag`.`article_comment_id` = `article_comments`.`id` 
                    and `title` like "%'.$keyword.'%")');
        }

        $this->communityQueries['generalQuestions'] = DB::table('general_questions')->select(
            'general_questions.id',
            'general_questions.updated_at',
            'general_questions.activity_month',
            'general_questions.activity_year',
            'general_questions.answers as replies',
            DB::raw('"'.CommunityType::GENERAL_QUESTION.'" as type')
        );

        if ($keyword) {
            $this->communityQueries['generalQuestions']->whereRaw('`title` like "%'.$keyword.'%"')
                ->orWhereRaw('exists
                    (select * from `tags` 
                    inner join `general_question_has_tag` on `tags`.`id` = `general_question_has_tag`.`tag_id` 
                    where `general_question_has_tag`.`question_id` like `general_questions`.`id` 
                    and `title` = "%'.$keyword.'%")');
        }
    }

    /**
     * @return mixed
     */
    protected function getQueryByType()
    {
        unset($this->parametersKeys[CommunityFilter::P_TYPE]);
        $type = $this->getSelected(CommunityFilter::P_TYPE)->first();

        switch ($type) {
            case CommunitySearchTypes::RECIPES:
                $query = $this->communityQueries['recipeReviews']
                    ->unionAll($this->communityQueries['recipeQuestions']);
                break;
            case CommunitySearchTypes::ARTICLE:
                $query = $this->communityQueries['articleComments'];
                break;
            case CommunitySearchTypes::GENERAL:
                $query = $this->communityQueries['generalQuestions'];
                break;
            case CommunitySearchTypes::ALL:
            default:
                $query = $this->communityQueries['recipeReviews']
                    ->unionAll($this->communityQueries['recipeQuestions'])
                    ->unionAll($this->communityQueries['articleComments'])
                    ->unionAll($this->communityQueries['generalQuestions']);
                break;
        }

        return $query;
    }

    /**
     * @param mixed $items
     * @return mixed
     */
    protected function getItems($items)
    {
        $models = collect();

        foreach ($items as $item) {
            switch ($item->type) {
                case CommunityType::RECIPE_REVIEW:
                    $models->push(Review::find($item->id));
                    break;
                case CommunityType::RECIPE_QUESTION:
                    $models->push(RecipeQuestion::find($item->id));
                    break;
                case CommunityType::ARTICLE_COMMENT:
                    $models->push(ArticleComment::find($item->id));
                    break;
                case CommunityType::GENERAL_QUESTION:
                default:
                    $models->push(GeneralQuestion::find($item->id));
                    break;
            }
        }

        return $models;
    }

    /**
     * @return array
     */
    protected function getPageSize()
    {
        $res = $this->getSelected(CommunityFilter::P_PAGESIZE)->first();
        $current = $res ?: config('kosher.pagination.recipes_list');
        $currentLink = \Request::url() . '?';
        $vars = \Request::all();
        unset($vars['page']);

        $links = collect(config('kosher.pagination.per_page_selector'))
            ->mapWithKeys(function ($item) use ($currentLink, $vars, $current) {
                $vars[CommunityFilter::P_PAGESIZE] = $item;
                return [
                    [
                        'link' => $currentLink . http_build_query($vars),
                        'label' => $item,
                        'selected' => $current == $item
                    ]
                ];
            });

        return [
            'key' => CommunityFilter::P_PAGESIZE,
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
        $selected = $this->getSelected(CommunityFilter::P_SORT)->flip()->keys()->first();
        if (empty($selected)) {
            $selected = CommunitySearchSorting::RECENT;
        }

        return [
            'key' => CommunityFilter::P_SORT,
            'all' => CommunitySearchSorting::labels(),
            'selected' => $selected,
            'label' => trans('search/lifestyle.labels.sort_by')
        ];
    }

    /**
     * @param mixed $query
     */
    protected function applyQueryBySort(&$query)
    {
        $selected = $this->getSelected(CommunityFilter::P_SORT)->first();

        switch ($selected) {
            case CommunitySearchSorting::RECENT:
                $query->orderBy('updated_at', 'desc');
                break;
            case CommunitySearchSorting::ACTIVITY:
            default:
                $query->orderBy('activity_year', 'DESC')
                    ->orderBy('activity_month', 'DESC')
                    ->orderBy('replies', 'DESC');
                break;
        }
    }

    /**
     * @return array
     */
    protected function getKeyword()
    {
        return [
            'key' => CommunityFilter::P_KEYWORD,
            'selected' => $this->getSelected(CommunityFilter::P_KEYWORD)->first(),
            'all' => []
        ];
    }

    /**
     * @return array
     */
    protected function getType()
    {
        $selected = $this->getSelected(CommunityFilter::P_TYPE)->first();
        if (empty($selected)) {
            $selected = CommunitySearchTypes::ALL;
        }

        return [
            'key' => CommunityFilter::P_TYPE,
            'selected' => $selected,
            'all' => CommunitySearchTypes::labels()
        ];
    }

    /**
     * Return most popular (voted) community items
     *
     * @return mixed
     */
    protected function getPopularItems()
    {
        $query = [];

        $query['recipeReviews'] = DB::table('reviews')->select(
            'reviews.id',
            'reviews.views',
            DB::raw('"'.CommunityType::RECIPE_REVIEW.'" as type')
        );

        $query['recipeQuestions'] = DB::table('recipe_questions')->select(
            'recipe_questions.id',
            'recipe_questions.views',
            DB::raw('"'.CommunityType::RECIPE_QUESTION.'" as type')
        );

        $query['articleComments'] = DB::table('article_comments')->select(
            'article_comments.id',
            'article_comments.views',
            DB::raw('"'.CommunityType::ARTICLE_COMMENT.'" as type')
        );

        $query['generalQuestions'] = DB::table('general_questions')->select(
            'general_questions.id',
            'general_questions.views',
            DB::raw('"'.CommunityType::GENERAL_QUESTION.'" as type')
        );

        return $query['recipeReviews']
            ->unionAll($query['recipeQuestions'])
            ->unionAll($query['articleComments'])
            ->unionAll($query['generalQuestions'])
            ->orderBy('views', 'DESC')
            ->take(config('kosher.pagination.community_popular_items'))
            ->get();
    }

    /**
     * Return most popular tags
     *
     * @param mixed $popularItems
     * @return mixed
     */
    protected function getPopularTags($popularItems)
    {
        $tags = collect();

        foreach ($popularItems as $item) {
            if ($item->tags) {
                foreach ($item->tags as $tag) {
                    $tags->push($tag);
                }
            }
        }

        return $tags->unique()->values()->shuffle()->take(config('kosher.pagination.community_popular_tags'));
    }
}
