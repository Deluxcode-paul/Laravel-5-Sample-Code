<?php

Route::group(['namespace' => 'Frontend'], function () {

    Route::group(['namespace' => 'Pages'], function () {
        Route::get('/', ['as' => 'home', 'uses' => 'Home']);
        Route::get('about/chefs', ['as' => 'about.chefs', 'uses' => 'About\Chefs']);
        Route::get('lifestyle', ['as' => 'lifestyle', 'uses' => 'Lifestyle']);
        Route::get('ajax/lifestyle', ['as' => 'ajax.lifestyle', 'uses' => 'LifestyleAjax']);
        Route::get('community', ['as' => 'community', 'uses' => 'Community']);
        Route::get('ajax/community', ['as' => 'ajax.community', 'uses' => 'CommunityAjax']);
        Route::get('generate-a-meal', ['as' => 'generate-a-meal', 'uses' => 'GenerateMeal']);
        Route::get('ajax/generate-a-meal', ['as' => 'ajax.generate-a-meal', 'uses' => 'GenerateMealAjax']);
        Route::get('watch', ['as' => 'watch', 'uses' => 'Watch']);
        Route::get('ajax/watch', ['as' => 'ajax.watch', 'uses' => 'WatchAjax']);
        Route::get('contact', ['as' => 'contact', 'uses' => 'Contact']);
        Route::post('contact', ['as' => 'contact.submit', 'uses' => 'ContactSubmit']);

        Route::get('lifestyle/article/{article}', ['as' => 'article.short', 'uses' => 'Lifestyle\View']);

        Route::group(['namespace' => 'Lifestyle', 'prefix' => 'lifestyle/article/{article}'], function () {
            Route::group(['namespace' => 'Article\Share', 'as' => 'article.'], function () {
                Route::get('print', ['as' => 'print', 'uses' => 'GetPrint']);
                Route::post('mail', ['as' => 'mail', 'uses' => 'SendMail', 'middleware' => 'ajax']);
                Route::post('share', ['as' => 'share', 'uses' => 'Share', 'middleware' => 'ajax']);
            });
            Route::group(['prefix' => 'comments', 'namespace' => 'Comments', 'as' => 'article-comments.'], function () {
                Route::post('view', ['as' => 'view', 'uses' => 'View']);
                Route::post('save/{question}', ['as' => 'save', 'uses' => 'Save']);
                Route::post('add', ['as' => 'add', 'uses' => 'Add']);
                Route::get('{question}', ['as' => 'edit', 'uses' => 'Edit']);
            });
            Route::get('{slug}', ['as' => 'article', 'uses' => 'View']);
        });

        Route::get('ajax/watch/show/{show}', ['as' => 'show.ajax', 'uses' => 'Watch\ShowLandingAjax']);

        Route::group(['namespace' => 'Watch', 'prefix' => 'watch', 'as' => 'watch.'], function () {
            Route::get('show/{show}', ['as' => 'show', 'uses' => 'ShowLanding']);
            Route::get('video/{video}', ['as' => 'video', 'uses' => 'GetVideo']);
            Route::post('video/{video}/mail', [
                'as' => 'video.mail',
                'uses' => 'Video\Share\SendMail',
                'middleware' => 'ajax'
            ]);
        });
    });

    Route::group(['prefix' => 'recipes', 'namespace' => 'Recipes', 'as' => 'recipes.'], function () {
        Route::get('/', ['as' => 'category', 'uses' => 'Category']);
        Route::get('list', ['as' => 'list', 'uses' => 'ListGet']);
        Route::get('list-ajax', ['as' => 'list-ajax', 'uses' => 'ListGetAjax']);
    });
    Route::group(['prefix' => 'ajax', 'namespace' => 'Recipes'], function () {
        Route::get('recipes/list', ['as' => 'recipes/list', 'uses' => 'ListGetAjax']);
    });

    Route::group(['prefix' => 'ajax', 'namespace' => 'Ajax', 'as' => 'ajax', 'middleware' => 'ajax'], function () {
        Route::get('megamenu', ['as' => 'megamenu', 'uses' => 'MegaMenu']);
        Route::get('call-to-actions', ['as' => 'call-to-actions', 'uses' => 'CallToActions']);
    });
});

/* Recipe Detail Page */

Route::group(['prefix' => 'recipe', 'namespace' => 'Frontend\Recipe', 'as' => 'recipe.'], function () {
    Route::get('pdf/{id}', ['as' => 'pdf', 'uses' => 'PdfGet']);
    Route::get('print/{id}', ['as' => 'print', 'uses' => 'PrintGet']);
    Route::post('share/{recipe}', ['as' => 'share', 'uses' => 'Share', 'middleware' => 'ajax']);
    Route::post('mail/{recipe}', ['as' => 'mail', 'uses' => 'SendMail', 'middleware' => 'ajax']);

    Route::group(['prefix' => 'reviews', 'namespace' => 'Reviews', 'as' => 'reviews.'], function () {
        Route::post('{recipe}/view', ['as' => 'view', 'uses' => 'View']);
        Route::post('{recipe}/save/{review}', ['as' => 'save', 'uses' => 'Save']);
        Route::post('{recipe}/add', ['as' => 'add', 'uses' => 'Add']);
        Route::get('{recipe}/{review}', ['as' => 'edit', 'uses' => 'Edit']);
    });

    Route::group(['prefix' => 'questions', 'namespace' => 'Questions', 'as' => 'questions.'], function () {
        Route::post('{recipe}/view', ['as' => 'view', 'uses' => 'View']);
        Route::post('{recipe}/save/{question}', ['as' => 'save', 'uses' => 'Save']);
        Route::post('{recipe}/add', ['as' => 'add', 'uses' => 'Add']);
        Route::get('{recipe}/{question}', ['as' => 'edit', 'uses' => 'Edit']);
    });

    Route::get('{id}', ['as' => 'view.short', 'uses' => 'View']);
    Route::get('{id}/{slug}', ['as' => 'view', 'uses' => 'View']);
});

/** User */
Route::group(['namespace' => 'Frontend\User', 'as' => 'user.'], function () {
    Route::post('user/shopping-list/add', ['as' => 'shopping-list.add', 'uses' => 'ShoppingList\Add']);
    Route::post('user/recipe-box/add', ['as' => 'recipe-box.add', 'uses' => 'RecipeBox\Add']);

    Route::group(['prefix' => 'user/{user}', 'namespace' => 'PublicProfile'], function () {
        Route::get('/', ['as' => 'view', 'uses' => 'View']);

        Route::group(['namespace' => 'Ajax', 'as' => 'ajax.', 'middleware' => 'ajax'], function () {
            Route::post('mail', ['as' => 'mail', 'uses' => 'Share\SendMail']);
            Route::get('recipes', ['as' => 'recipes', 'uses' => 'Recipes']);
            Route::get('articles', ['as' => 'articles', 'uses' => 'Articles']);
            Route::get('videos', ['as' => 'videos', 'uses' => 'Videos']);
            Route::get('article-comments', ['as' => 'article-comments', 'uses' => 'ArticleComments']);
            Route::get('community-questions', ['as' => 'community-questions', 'uses' => 'CommunityQuestions']);
            Route::get('recipe-questions', ['as' => 'recipe-questions', 'uses' => 'RecipeQuestions']);
            Route::get('recipe-reviews', ['as' => 'recipe-reviews', 'uses' => 'RecipeReviews']);
        });
    });
});

Route::group(['prefix' => 'search', 'namespace' => 'Frontend\Search', 'as' => 'search.'], function () {
    /** Autocomplete */
    Route::get('ingredient', ['as' => 'ingredient', 'uses' => 'Ajax\IngredientGet']);
    Route::get('chefs', ['as' => 'chefs', 'uses' => 'Ajax\ChefsGet']);
    Route::get('tags', ['as' => 'tags', 'uses' => 'Ajax\TagsGet']);

    Route::get('/', ['as' => 'redirect', 'uses' => 'SearchRedirect']);
    Route::get('lifestyle', ['as' => 'lifestyle', 'uses' => 'Lifestyle']);
    Route::get('chef', ['as' => 'chef', 'uses' => 'Chefs']);
    Route::get('watch', ['as' => 'watch', 'uses' => 'Watch']);

    Route::get('recipes', ['as' => 'recipes', 'uses' => 'Recipes']);
    // Route::post('recipes', ['as' => 'recipes-ajax', 'uses' => 'RecipesAjax']);
});

Route::group(['prefix' => 'ajax/search', 'namespace' => 'Frontend\Search'], function () {
    Route::get('recipes', ['as' => 'recipes-ajax', 'uses' => 'RecipesAjax']);
    Route::get('lifestyle', ['as' => 'lifestyle-ajax', 'uses' => 'LifestyleAjax']);
    Route::get('watch', ['as' => 'watch-ajax', 'uses' => 'WatchAjax']);
    Route::get('chef', ['as' => 'chef-ajax', 'uses' => 'ChefsAjax']);
});

Route::group([
    'prefix' => 'ajax/community',
    'namespace' => 'Frontend\Community',
    'as' => 'ajax.community.'
], function () {
    Route::get('recipe-review/{item}', ['as' => 'recipe-review', 'uses' => 'RecipeReview\ViewAjax']);
    Route::get('recipe-question/{item}', ['as' => 'recipe-question', 'uses' => 'RecipeQuestion\ViewAjax']);
    Route::get('article-comment/{item}', ['as' => 'article-comment', 'uses' => 'ArticleComment\ViewAjax']);
    Route::get('community-question/{item}', ['as' => 'community-question', 'uses' => 'GeneralQuestion\ViewAjax']);
});

Route::group(['prefix' => 'community', 'namespace' => 'Frontend\Community', 'as' => 'community.'], function () {
    Route::group(['namespace' => 'Question', 'middleware' => 'auth'], function () {
        Route::get('ask-question', ['as' => 'ask-question', 'uses' => 'AskQuestion']);
        Route::post('ask-question', ['as' => 'ask-question.save', 'uses' => 'SaveQuestion']);
    });
    Route::get('recipe-review/{item}', ['as' => 'recipe-review', 'uses' => 'RecipeReview\View']);
    Route::get('recipe-question/{item}', ['as' => 'recipe-question', 'uses' => 'RecipeQuestion\View']);
    Route::get('article-comment/{item}', ['as' => 'article-comment', 'uses' => 'ArticleComment\View']);
    Route::get('community-question/{item}', ['as' => 'community-question', 'uses' => 'GeneralQuestion\View']);

    Route::get('recipe-review/{item}/edit', [
        'as' => 'recipe-review.edit',
        'uses' => 'RecipeReview\Edit',
        'middleware' => 'can:edit,item'
    ]);
    Route::get('recipe-question/{item}/edit', [
        'as' => 'recipe-question.edit',
        'uses' => 'RecipeQuestion\Edit',
        'middleware' => 'can:edit,item'
    ]);
    Route::get('article-comment/{item}/edit', [
        'as' => 'article-comment.edit',
        'uses' => 'ArticleComment\Edit',
        'middleware' => 'can:edit,item'
    ]);
    Route::get('community-question/{item}/edit', [
        'as' => 'community-question.edit',
        'uses' => 'GeneralQuestion\Edit',
        'middleware' => 'can:edit,item'
    ]);

    Route::post('recipe-review/{item}/save', [
        'as' => 'recipe-review.save',
        'uses' => 'RecipeReview\Save',
        'middleware' => 'can:edit,item'
    ]);
    Route::post('recipe-question/{item}/save', [
        'as' => 'recipe-question.save',
        'uses' => 'RecipeQuestion\Save',
        'middleware' => 'can:edit,item'
    ]);
    Route::post('article-comment/{item}/save', [
        'as' => 'article-comment.save',
        'uses' => 'ArticleComment\Save',
        'middleware' => 'can:edit,item'
    ]);
    Route::post('community-question/{item}/save', [
        'as' => 'community-question.save',
        'uses' => 'GeneralQuestion\Save',
        'middleware' => 'can:edit,item'
    ]);

    Route::get('recipe-review/{item}/delete', [
        'as' => 'recipe-review.delete',
        'uses' => 'RecipeReview\Delete',
        'middleware' => 'can:edit,item'
    ]);
    Route::get('recipe-question/{item}/delete', [
        'as' => 'recipe-question.delete',
        'uses' => 'RecipeQuestion\Delete',
        'middleware' => 'can:edit,item'
    ]);
    Route::get('article-comment/{item}/delete', [
        'as' => 'article-comment.delete',
        'uses' => 'ArticleComment\Delete',
        'middleware' => 'can:edit,item'
    ]);
    Route::get('community-question/{item}/delete', [
        'as' => 'community-question.delete',
        'uses' => 'GeneralQuestion\Delete',
        'middleware' => 'can:edit,item'
    ]);

    Route::get('article-reply/{item}/edit', [
        'as' => 'article-reply.edit',
        'uses' => 'ArticleReply\Edit',
        'middleware' => 'can:edit,item'
    ]);
    Route::get('community-answer/{item}/edit', [
        'as' => 'community-answer.edit',
        'uses' => 'GeneralAnswer\Edit',
        'middleware' => 'can:edit,item'
    ]);
    Route::get('recipe-answer/{item}/edit', [
        'as' => 'recipe-answer.edit',
        'uses' => 'RecipeAnswer\Edit',
        'middleware' => 'can:edit,item'
    ]);
    Route::get('review-comment/{item}/edit', [
        'as' => 'review-comment.edit',
        'uses' => 'ReviewComment\Edit',
        'middleware' => 'can:edit,item'
    ]);

    Route::post('article-reply/{item}/save', [
        'as' => 'article-reply.save',
        'uses' => 'ArticleReply\Save',
        'middleware' => 'can:edit,item'
    ]);
    Route::post('community-answer/{item}/save', [
        'as' => 'community-answer.save',
        'uses' => 'GeneralAnswer\Save',
        'middleware' => 'can:edit,item'
    ]);
    Route::post('recipe-answer/{item}/save', [
        'as' => 'recipe-answer.save',
        'uses' => 'RecipeAnswer\Save',
        'middleware' => 'can:edit,item'
    ]);
    Route::post('review-comment/{item}/save', [
        'as' => 'review-comment.save',
        'uses' => 'ReviewComment\Save',
        'middleware' => 'can:edit,item'
    ]);

    Route::get('article-reply/{item}/delete', [
        'as' => 'article-reply.delete',
        'uses' => 'ArticleReply\Delete',
        'middleware' => 'can:edit,item'
    ]);
    Route::get('community-answer/{item}/delete', [
        'as' => 'community-answer.delete',
        'uses' => 'GeneralAnswer\Delete',
        'middleware' => 'can:edit,item'
    ]);
    Route::get('recipe-answer/{item}/delete', [
        'as' => 'recipe-answer.delete',
        'uses' => 'RecipeAnswer\Delete',
        'middleware' => 'can:edit,item'
    ]);
    Route::get('review-comment/{item}/delete', [
        'as' => 'review-comment.delete',
        'uses' => 'ReviewComment\Delete',
        'middleware' => 'can:edit,item'
    ]);
});

Route::get('home', function () {
    return redirect()->to('');
});
// DO NOT REMOVE
Route::get('maintenance', function () {
    return view('pages.maintenance');
})->name('maintenance');
