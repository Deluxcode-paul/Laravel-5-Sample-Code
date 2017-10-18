<?php

Route::group(['namespace' => 'Frontend\Pages'], function () {
    Route::get('about/chefs', ['as' => 'about.chefs', 'uses' => 'Maintenance']);
    Route::get('lifestyle', ['as' => 'lifestyle', 'uses' => 'Maintenance']);
    Route::get('generate-a-meal', ['as' => 'generate-a-meal', 'uses' => 'Maintenance']);
    Route::get('watch', ['as' => 'watch', 'uses' => 'Maintenance']);
    Route::get('contact', ['as' => 'contact', 'uses' => 'Maintenance']);

    Route::group(['prefix' => 'lifestyle/article/{article}'], function () {
        Route::get('/', ['as' => 'article', 'uses' => 'Maintenance']);
    });

    Route::group(['prefix' => 'watch', 'as' => 'watch.'], function () {
        Route::get('show/{show}', ['as' => 'show', 'uses' => 'Maintenance']);
        Route::get('video/{video}', ['as' => 'video', 'uses' => 'Maintenance']);
    });

    Route::group(['prefix' => 'recipes', 'as' => 'recipes.'], function () {
        Route::get('list', ['as' => 'list', 'uses' => 'Maintenance']);
    });

    Route::group(['as' => 'user.', 'prefix' => 'user/{user}'], function () {
        Route::get('/', ['as' => 'view', 'uses' => 'Maintenance']);
    });

    Route::group(['prefix' => 'search', 'as' => 'search.'], function () {
        Route::get('/', ['as' => 'redirect', 'uses' => 'Maintenance']);
        Route::get('lifestyle', ['as' => 'lifestyle', 'uses' => 'Maintenance']);
        Route::get('chef', ['as' => 'chef', 'uses' => 'Maintenance']);
        Route::get('watch', ['as' => 'watch', 'uses' => 'Maintenance']);
        Route::get('recipes', ['as' => 'recipes', 'uses' => 'Maintenance']);
    });

    Route::group(['prefix' => 'community', 'as' => 'community.'], function () {
        Route::get('/', ['as' => 'landing', 'uses' => 'Maintenance']);
        Route::get('recipe-review/{item}', ['as' => 'recipe-review', 'uses' => 'Maintenance']);
        Route::get('recipe-question/{item}', ['as' => 'recipe-question', 'uses' => 'Maintenance']);
    });

    Route::group(['prefix' => 'user', 'as' => 'user.', 'middleware' => 'auth'], function () {
        Route::group(['prefix' => 'profile', 'as' => 'profile.'], function () {
            Route::get('account', function () {
                return redirect()->to('');
            })->name('account.view');

            Route::group(['prefix' => 'activity', 'as' => 'activity.'], function () {
                Route::get('recipe-questions', ['as' => 'recipe-questions', 'uses' => 'Maintenance']);
                Route::get('recipe-reviews', ['as' => 'recipe-reviews', 'uses' => 'Maintenance']);
                Route::get('article-comments', ['as' => 'article-comments', 'uses' => 'Maintenance']);
                Route::get('community-questions', ['as' => 'community-questions', 'uses' => 'Maintenance']);
            });

            Route::get('recipe-box', ['as' => 'recipe-box.view', 'uses' => 'Maintenance']);
            Route::get('my-recipes', ['as' => 'my-recipes.view', 'uses' => 'Maintenance']);
            Route::get('my-articles', ['as' => 'my-articles.view', 'uses' => 'Maintenance']);

            Route::group(['prefix' => 'shopping-lists', 'as' => 'shopping-lists.'], function () {
                Route::get('/', ['as' => 'view', 'uses' => 'Maintenance']);
            });
        });
    });
});
