<?php

namespace App\Http\Controllers\Frontend\Pages;

use App\Enums\CommunityType;
use App\Http\Controllers\Controller;
use App\Models\ArticleComment;
use App\Models\GeneralQuestion;
use App\Models\Recipe;
use App\Models\RecipeQuestion;
use App\Models\Review;
use App\Models\User;
use App\Models\Article;
use App\Models\Show;
use Illuminate\Support\Facades\Cache;
use App\Enums\UserRole;
use Illuminate\Support\Facades\DB;
use Assets;

/**
 * Class Home
 * @package App\Http\Controllers\Frontend\Pages
 */
class Home extends Controller
{
    /**
     * @var array Received Recipes
     */
    protected $receivedRecipes;

    /**
     * @var array
     */
    protected $communityQueries = [];

    /**
     * Controller main action
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function __invoke()
    {
        $this->receivedRecipes = collect();

        $bannerItems = $this->getBannerItems();
        $newestRecipes = $this->getNewestRecipes();
        $archivedRecipes = $this->getArchivedRecipes();

        $mostPopularRecipes = $this->getMostPopularRecipes();
        $mainMostPopularRecipe = $mostPopularRecipes->shift();
        $mostSharedRecipes = $this->getMostSharedRecipes();
        $mainMostSharedRecipe = $mostSharedRecipes->shift();
        $mainThisWeekRecipes = collect([$mainMostPopularRecipe, $mainMostSharedRecipe]);
        $thisWeekRecipes = $mostPopularRecipes->merge($mostSharedRecipes)->shuffle();

        $chefs = $this->getChefs();
        $articles = $this->getArticles();
        $mainArticle = $articles->shift();

        if (Cache::has('home_community')) {
            $community = Cache::get('home_community');
        } else {
            $community = $this->getCommunityModels($this->getCommunityItems());
        }

        Assets::group('frontend')->addJs('user/profile/activity.js');

        return view('pages.home', compact(
            'bannerItems',
            'newestRecipes',
            'archivedRecipes',
            'chefs',
            'mainArticle',
            'articles',
            'mainThisWeekRecipes',
            'thisWeekRecipes',
            'community'
        ));
    }

    /**
     * Return items for banner
     * @return mixed
     */
    protected function getBannerItems()
    {
        $self = $this;

        return Cache::remember(
            'home_banner_items',
            config('kosher.cache_expiration_time'),
            function () use ($self) {
                $recipes = Recipe::banner()->with('categories')->get();
                $articles = Article::banner()->published()->with('category')->get();
                $shows = Show::banner()->get();

                $banner = $recipes->merge($articles)
                    ->merge($shows)
                    ->shuffle()
                    ->take(config('kosher.pagination.home_banner_items'));

                if (0 == $banner->count()) {
                    $recipes = Recipe::featured()->with('categories')->get();
                    $articles = Article::featured()->published()->with('category')->get();
                    $shows = Show::featured()->get();

                    $banner = $recipes->merge($articles)
                        ->merge($shows)
                        ->shuffle()
                        ->take(config('kosher.pagination.home_banner_items'));
                }

                if (0 == $banner->count()) {
                    $banner = Recipe::published()
                        ->with('categories')
                        ->take(config('kosher.pagination.home_banner_items'))
                        ->get();
                    $self->mergeReceivedRecipes($banner);
                } else {
                    $recipes = collect();
                    foreach ($banner as $item) {
                        if ($item->isRecipe()) {
                            $recipes->push($item);
                        }
                    }
                    $self->mergeReceivedRecipes($recipes);
                }

                return $banner;
            }
        );
    }

    /**
     * Return newest recipes
     * @return mixed
     */
    protected function getNewestRecipes()
    {
        $self = $this;

        $result = Cache::remember(
            'home_newestRecipes',
            config('kosher.cache_expiration_time'),
            function () use ($self) {
                return Recipe::newest()->with('user', 'videos')
                    ->whereNotIn('id', $self->receivedRecipes->all())
                    ->take(config('kosher.pagination.home_newest_recipes'))
                    ->get();
            }
        );

        $this->mergeReceivedRecipes($result);

        return $result;
    }

    /**
     * Return archived recipes
     * @return mixed
     */
    protected function getArchivedRecipes()
    {
        $self = $this;

        $result = Cache::remember(
            'home_archivedRecipes',
            config('kosher.cache_expiration_time'),
            function () use ($self) {
                return Recipe::archived()->with('user', 'videos')
                    ->whereNotIn('id', $self->receivedRecipes->all())
                    ->random()
                    ->take(config('kosher.pagination.home_archived_recipes'))
                    ->get();
            }
        );

        $this->mergeReceivedRecipes($result);

        return $result;
    }

    /**
     * Merge received recipes
     * @param $recipes
     */
    protected function mergeReceivedRecipes($recipes)
    {
        if ($recipes->count()) {
            $this->receivedRecipes = $this->receivedRecipes->merge($recipes->pluck('id'));
        }
    }

    /**
     * Return featured chefs
     * @return mixed
     */
    protected function getChefs()
    {
        return Cache::remember(
            'home_chefs',
            config('kosher.cache_expiration_time'),
            function () {
                return User::whereHas('roles', function ($query) {
                    $query->whereIn('id', [UserRole::ROLE_COMMUNITY_CHEF, UserRole::ROLE_PROFESSIONAL_CHEF]);
                })
                    ->featured()
                    ->random()
                    ->take(config('kosher.pagination.home_chefs'))
                    ->get();
            }
        );
    }

    /**
     * Return featured articles
     * @return mixed
     */
    protected function getArticles()
    {
        return Cache::remember(
            'home_articles',
            config('kosher.cache_expiration_time'),
            function () {
                $articles = Article::published()
                    ->with('user', 'videos')
                    ->recent()
                    ->featured()
                    ->take(config('kosher.pagination.home_articles'))
                    ->get();

                if (config('kosher.pagination.home_articles') > $articles->count()) {
                    $limit = config('kosher.pagination.home_articles') - $articles->count();
                    $recentArticles = Article::published()
                        ->with('user', 'videos')
                        ->where('is_featured', 0)
                        ->recent()
                        ->take($limit)
                        ->get();

                    $articles = $articles->merge($recentArticles);
                }

                return $articles;
            }
        );
    }

    /**
     * Return most popular recipes
     * @return mixed
     */
    protected function getMostPopularRecipes()
    {
        $self = $this;

        $result = Cache::remember(
            'home_popularRecipes',
            config('kosher.cache_expiration_time'),
            function () use ($self) {
                return Recipe::mostPopular()->with('user', 'videos')
                    ->whereNotIn('recipes.id', $self->receivedRecipes->all())
                    ->take(config('kosher.pagination.home_popular_recipes'))
                    ->get();
            }
        );

        $this->mergeReceivedRecipes($result);

        return $result;
    }

    /**
     * Return most shared recipes
     * @return mixed
     */
    protected function getMostSharedRecipes()
    {
        $self = $this;

        $result = Cache::remember(
            'home_sharedRecipes',
            config('kosher.cache_expiration_time'),
            function () use ($self) {
                return Recipe::mostShared()->with('user', 'videos')
                    ->whereNotIn('recipes.id', $self->receivedRecipes->all())
                    ->take(config('kosher.pagination.home_shared_recipes'))
                    ->get();
            }
        );

        $this->mergeReceivedRecipes($result);

        return $result;
    }

    /**
     * Return community items
     */
    protected function getCommunityItems()
    {
        $this->initCommunityQueries();

        return $this->communityQueries['recipeReviews']
            ->unionAll($this->communityQueries['recipeQuestions'])
            ->unionAll($this->communityQueries['articleComments'])
            ->unionAll($this->communityQueries['generalQuestions'])
            ->orderBy('activity_year', 'DESC')
            ->orderBy('activity_month', 'DESC')
            ->orderBy('replies', 'DESC')
            ->take(config('kosher.pagination.home_community'))
            ->get();
    }

    /**
     * Init community queries
     */
    protected function initCommunityQueries()
    {
        $this->communityQueries['recipeReviews'] = DB::table('reviews')->select(
            'reviews.id',
            'reviews.activity_month',
            'reviews.activity_year',
            'reviews.comments as replies',
            DB::raw('"' . CommunityType::RECIPE_REVIEW . '" as type')
        );

        $this->communityQueries['recipeQuestions'] = DB::table('recipe_questions')->select(
            'recipe_questions.id',
            'recipe_questions.activity_month',
            'recipe_questions.activity_year',
            'recipe_questions.answers as replies',
            DB::raw('"' . CommunityType::RECIPE_QUESTION . '" as type')
        );

        $this->communityQueries['articleComments'] = DB::table('article_comments')->select(
            'article_comments.id',
            'article_comments.activity_month',
            'article_comments.activity_year',
            'article_comments.replies',
            DB::raw('"' . CommunityType::ARTICLE_COMMENT . '" as type')
        );

        $this->communityQueries['generalQuestions'] = DB::table('general_questions')->select(
            'general_questions.id',
            'general_questions.activity_month',
            'general_questions.activity_year',
            'general_questions.answers as replies',
            DB::raw('"' . CommunityType::GENERAL_QUESTION . '" as type')
        );
    }

    /**
     * @param $items
     * @return \Illuminate\Support\Collection
     */
    protected function getCommunityModels($items)
    {
        $result = collect();

        foreach ($items as $item) {
            switch ($item->type) {
                case CommunityType::RECIPE_REVIEW:
                    $result->push(Review::find($item->id));
                    break;
                case CommunityType::RECIPE_QUESTION:
                    $result->push(RecipeQuestion::find($item->id));
                    break;
                case CommunityType::ARTICLE_COMMENT:
                    $result->push(ArticleComment::find($item->id));
                    break;
                case CommunityType::GENERAL_QUESTION:
                default:
                    $result->push(GeneralQuestion::find($item->id));
                    break;
            }
        }

        Cache::put('home_community', $result, config('kosher.cache_expiration_time'));

        return $result;
    }
}
