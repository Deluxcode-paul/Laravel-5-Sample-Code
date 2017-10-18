<?php

namespace App\Providers;

use Illuminate\Support\Facades\Event;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        'App\Events\Article\ArticleViewed' => [
            'App\Listeners\Article\UpdateArticleViews',
        ],
        'App\Events\Article\ArticleShared' => [
            'App\Listeners\Article\UpdateArticleShares',
        ],

        'App\Events\Recipe\RecipeViewed' => [
            'App\Listeners\Recipe\UpdateRecipeViews',
        ],
        'App\Events\Recipe\RecipeShared' => [
            'App\Listeners\Recipe\UpdateRecipeShares',
        ],

        'Bfm\Forms\Events\FormSubmitted' => [
            'App\Listeners\Forms\SendAdminFormEmail',
        ],

        'App\Events\RecipeReview\RecipeReviewViewed' => [
            'App\Listeners\RecipeReview\UpdateRecipeReviewViews',
        ],
        'App\Events\RecipeQuestion\RecipeQuestionViewed' => [
            'App\Listeners\RecipeQuestion\UpdateRecipeQuestionViews',
        ],
        'App\Events\GeneralQuestion\GeneralQuestionViewed' => [
            'App\Listeners\GeneralQuestion\UpdateGeneralQuestionViews',
        ],
        'App\Events\ArticleComment\ArticleCommentViewed' => [
            'App\Listeners\ArticleComment\UpdateArticleCommentViews',
        ],

        'App\Events\RecipeReview\RecipeReviewPosted' => [
            'App\Listeners\RecipeReview\AddCommunityNotification',
        ],
        'App\Events\RecipeQuestion\RecipeQuestionPosted' => [
            'App\Listeners\RecipeQuestion\AddCommunityNotification',
        ],
        'App\Events\GeneralQuestion\GeneralQuestionPosted' => [
            'App\Listeners\GeneralQuestion\AddCommunityNotification',
        ],
        'App\Events\ArticleComment\ArticleCommentPosted' => [
            'App\Listeners\ArticleComment\AddCommunityNotification',
        ],

        'App\Events\ReviewComment\ReviewCommentPosted' => [
            'App\Listeners\ReviewComment\AddCommunityNotification',
        ],
        'App\Events\RecipeAnswer\RecipeAnswerPosted' => [
            'App\Listeners\RecipeAnswer\AddCommunityNotification',
        ],
        'App\Events\GeneralAnswer\GeneralAnswerPosted' => [
            'App\Listeners\GeneralAnswer\AddCommunityNotification',
        ],
        'App\Events\ArticleReply\ArticleReplyPosted' => [
            'App\Listeners\ArticleReply\AddCommunityNotification',
        ],

    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        //
    }
}
