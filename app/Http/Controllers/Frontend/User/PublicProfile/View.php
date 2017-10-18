<?php

namespace App\Http\Controllers\Frontend\User\PublicProfile;

use App\Http\Controllers\Controller;
use App\Models\ArticleComment;
use App\Models\GeneralQuestion;
use App\Models\User;
use App\Models\Review;
use App\Models\RecipeQuestion;
use Assets;

/**
 * Class View
 * @package App\Http\Controllers\Frontend\User\PublicProfile
 */
class View extends Controller
{
    /**
     * @var \App\Models\User $user
     */
    protected $user;

    /**
     * @param User $user
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function __invoke(User $user)
    {
        $this->user = $user;

        if (!$this->user->isChef()) {
            abort(404);
        }

        $recipes = $this->getUserRecipes();
        $articles = $this->getUserArticles();
        $videos = $this->getUserVideos();

        $recipeQuestions = $this->getUserRecipeQuestions();
        $recipeReviews = $this->getUserRecipeReviews();
        $articleComments = $this->getUserArticleComments();
        $communityQuestions = $this->getUserCommunityQuestions();

        Assets::group('frontend')->addJs('share/email.js');
        Assets::group('frontend')->addJs('user/profile/view.js');
        Assets::group('frontend')->addJs('user/profile/activity.js');

        return view('user.public_profile.view', compact(
            'user',
            'recipes',
            'articles',
            'videos',
            'recipeQuestions',
            'recipeReviews',
            'articleComments',
            'communityQuestions'
        ));
    }

    /**
     * Return user recipes
     * @return mixed
     */
    private function getUserRecipes()
    {
        $recipesPerPage = config('kosher.pagination.recipes_public_profile');

        return $this->user->recipes()
            ->recent()
            ->paginate($recipesPerPage);
    }

    /**
     * Return user videos
     * @return mixed
     */
    private function getUserVideos()
    {
        $perPage = config('kosher.pagination.videos_public_profile');

        return $this->user->queryChefVideos()
            ->recent()
            ->paginate($perPage);
    }

    /**
     * Return user articles
     * @return mixed
     */
    private function getUserArticles()
    {
        $articlesPerPage = config('kosher.pagination.articles_public_profile');

        return $this->user->articles()
            ->published()
            ->recent()
            ->paginate($articlesPerPage);
    }

    /**
     * @return mixed
     */
    private function getUserRecipeQuestions()
    {
        $itemsPerPage = config('kosher.pagination.comments_public_profile');

        return RecipeQuestion::forUser($this->user->id)
            ->recent()
            ->paginate($itemsPerPage);
    }

    /**
     * @return mixed
     */
    private function getUserRecipeReviews()
    {
        $itemsPerPage = config('kosher.pagination.comments_public_profile');

        return Review::forUser($this->user->id)
            ->recent()
            ->paginate($itemsPerPage);
    }

    /**
     * @return mixed
     */
    private function getUserArticleComments()
    {
        $itemsPerPage = config('kosher.pagination.comments_public_profile');

        return ArticleComment::forUser($this->user->id)
            ->recent()
            ->paginate($itemsPerPage);
    }

    /**
     * @return mixed
     */
    private function getUserCommunityQuestions()
    {
        $itemsPerPage = config('kosher.pagination.comments_public_profile');

        return GeneralQuestion::forUser($this->user->id)
            ->recent()
            ->paginate($itemsPerPage);
    }
}
