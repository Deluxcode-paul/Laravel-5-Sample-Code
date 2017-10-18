<?php

Route::group(['prefix' => 'ajax/user/profile',
    'namespace' => 'Frontend\User\Profile',
    'as' => 'ajax.user.profile.',
    'middleware' => 'auth'
], function () {
    Route::get('my-articles', [
        'as' => 'my-articles.view',
        'uses' => 'MyArticles\ViewAjax'
    ]);

    Route::get('my-recipes', [
        'as' => 'my-recipes.view',
        'uses' => 'MyRecipes\ViewAjax'
    ]);

    Route::get('recipe-box', [
        'as' => 'recipe-box.view',
        'uses' => 'RecipeBox\ViewAjax'
    ]);

    Route::get('activity/recipe-questions', [
        'as' => 'activity.recipe-questions',
        'uses' => 'Activity\RecipeQuestionsAjax'
    ]);

    Route::get('activity/recipe-reviews', [
        'as' => 'activity.recipe-reviews',
        'uses' => 'Activity\RecipeReviewsAjax'
    ]);

    Route::get('activity/article-comments', [
        'as' => 'activity.article-comments',
        'uses' => 'Activity\ArticleCommentsAjax'
    ]);

    Route::get('activity/community-questions', [
        'as' => 'activity.community-questions',
        'uses' => 'Activity\CommunityQuestionsAjax'
    ]);
});

Route::group(['prefix' => 'user',
    'namespace' => 'Frontend\User',
    'as' => 'user.',
    'middleware' => 'auth'
], function () {
    Route::group(['prefix' => 'profile', 'namespace' => 'Profile', 'as' => 'profile.'], function () {
        // Home > Your Profile > Account
        Route::get('account', ['as' => 'account.view', 'uses' => 'Account\View']);
        Route::post('account/delete', ['as' => 'account.delete', 'uses' => 'Account\Delete']);
        Route::post('account/confirmation', [
            'as' => 'account.confirmation',
            'uses' => 'Account\SendConfirmation',
            'middleware' => 'ajax'
        ]);
        // Home > Your Profile > Account Edit
        Route::group(['prefix' => 'account/edit', 'namespace' => 'Account\Edit', 'as' => 'account.edit.'], function () {
            Route::post('about', ['as' => 'about', 'uses' => 'About', 'middleware' => 'ajax']);
            Route::post('social', ['as' => 'social', 'uses' => 'Social', 'middleware' => 'ajax']);
            Route::post('preferences', ['as' => 'preferences', 'uses' => 'Preferences', 'middleware' => 'ajax']);
        });
        // Home > Your Profile > Account Save
        Route::group(['prefix' => 'account/save', 'namespace' => 'Account\Save', 'as' => 'account.save.'], function () {
            Route::post('about', ['as' => 'about', 'uses' => 'About', 'middleware' => 'ajax']);
            Route::post('social', ['as' => 'social', 'uses' => 'Social', 'middleware' => 'ajax']);
            Route::post('preferences', ['as' => 'preferences', 'uses' => 'Preferences', 'middleware' => 'ajax']);
            Route::post('image', ['as' => 'image', 'uses' => 'Image']);
            Route::post('subscription', ['as' => 'subscription', 'uses' => 'Subscription', 'middleware' => 'ajax']);
        });
        // Home > Your Profile > Activity
        Route::group(['prefix' => 'activity', 'namespace' => 'Activity', 'as' => 'activity.'], function () {
            Route::get('recipe-questions', ['as' => 'recipe-questions', 'uses' => 'RecipeQuestions']);
            Route::get('recipe-reviews', ['as' => 'recipe-reviews', 'uses' => 'RecipeReviews']);
            Route::get('article-comments', ['as' => 'article-comments', 'uses' => 'ArticleComments']);
            Route::get('community-questions', ['as' => 'community-questions', 'uses' => 'CommunityQuestions']);

            Route::group(['namespace' => 'Ajax', 'middleware' => 'ajax'], function () {
                Route::post('report-abuse', ['as' => 'report-abuse', 'uses' => 'ReportAbuse']);
                Route::post('vote', ['as' => 'vote', 'uses' => 'Vote']);
                Route::group(['namespace' => 'Reply', 'as' => 'reply.'], function () {
                    Route::post('reply/recipe-review/{review}', [
                        'as' => 'recipe-review',
                        'uses' => 'RecipeReview'
                    ]);
                    Route::post('reply/recipe-question/{question}', [
                        'as' => 'recipe-question',
                        'uses' => 'RecipeQuestion'
                    ]);
                    Route::post('reply/article-comment/{comment}', [
                        'as' => 'article-comment',
                        'uses' => 'ArticleComment'
                    ]);
                    Route::post('reply/community-question/{question}', [
                        'as' => 'community-question',
                        'uses' => 'GeneralQuestion'
                    ]);
                });
            });
        });
        // Home > Your Profile > Recipe Box
        Route::get('recipe-box', ['as' => 'recipe-box.view', 'uses' => 'RecipeBox\View']);
        // Home > Your Profile > My Recipes
        Route::get('my-recipes', ['as' => 'my-recipes.view', 'uses' => 'MyRecipes\View']);
        // Home > Your Profile > My Articles
        Route::get('my-articles', ['as' => 'my-articles.view', 'uses' => 'MyArticles\View']);
        // Home > Your Profile > Shopping Lists
        Route::group([
            'prefix' => 'shopping-lists',
            'namespace' => 'ShoppingLists',
            'as' => 'shopping-lists.'
        ], function () {
            Route::get('/', ['as' => 'view', 'uses' => 'View']);
            Route::group(['namespace' => 'Share',], function () {
                Route::post('pdf', ['as' => 'pdf', 'uses' => 'GetPdf']);
                Route::get('print', ['as' => 'print', 'uses' => 'GetPrint']);
                Route::post('mail', ['as' => 'mail', 'uses' => 'SendMail', 'middleware' => 'ajax']);
            });
            Route::group(['prefix' => 'delete', 'namespace' => 'Delete', 'as' => 'delete.'], function () {
                Route::post('recipe', ['as' => 'recipe', 'uses' => 'Recipe']);
                Route::post('ingredient', ['as' => 'ingredient', 'uses' => 'Ingredient', 'middleware' => 'ajax']);
            });
        });
    });
});
