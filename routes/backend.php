<?php

Route::group(['prefix' => 'admin', 'middleware' => 'can:admin-access'], function () {

    Route::get('dashboard', '\Backpack\Base\app\Http\Controllers\AdminController@dashboard');
    Route::get('/', '\Backpack\Base\app\Http\Controllers\AdminController@redirect');
    Route::get('login', function () {
        return redirect()->to('admin/dashboard');
    });

    Route::group(['namespace' => 'Backend'], function () {
        Route::group(['namespace' => 'System', 'as' => 'backend.system.', 'prefix' => 'system'], function () {
            Route::get('flush-cache', ['as' => 'flush-cache', 'uses' => 'FlushCache']);
            Route::get('flush-thumbnails', ['as' => 'flush-thumbnails', 'uses' => 'FlushThumbnails']);
        });

        Route::post('ajax/checkbox', [
            'as' => 'backend.ajax.checkbox',
            'uses' => 'Ajax\Checkbox'
        ]);

        Route::post('ajax/filter', [
            'as' => 'backend.ajax.filter',
            'uses' => 'Ajax\Filter'
        ]);

        Route::group(['middleware' => 'can:articles-access'], function () {
            CRUD::resource('articles', 'ArticleCrud');
            CRUD::resource('articles/{owner}/videos', 'ArticleVideoCrud');
        });

        Route::group(['middleware' => 'can:recipes-access'], function () {
            CRUD::resource('recipes', 'RecipeCrud');
            CRUD::resource('recipes/{owner}/ingredients', 'RecipeIngredientCrud');
            CRUD::resource('recipes/{owner}/directions', 'RecipeCookingCrud');
            CRUD::resource('directions/{owner}/steps', 'CookingStepCrud');
            CRUD::resource('recipes/{owner}/images', 'RecipeImageCrud');
            CRUD::resource('recipes/{owner}/videos', 'RecipeVideoCrud');

            CRUD::resource('my-reviews', 'MyReviewCrud');
            CRUD::resource('my-review-comments', 'MyReviewCommentCrud');
            CRUD::resource('my-recipe-questions', 'MyRecipeQuestionCrud');
            CRUD::resource('my-recipe-answers', 'MyRecipeAnswerCrud');

            Route::get('ajax/ingredient-groups', [
                'as' => 'backend.ajax.ingredient_groups',
                'uses' => 'Ajax\IngredientGroups'
            ]);

            Route::get('ajax/tags', [
                'as' => 'backend.ajax.tags',
                'uses' => 'Ajax\Tags'
            ]);
        });

        Route::group(['middleware' => 'can:admin-full-access'], function () {
            CRUD::resource('allergens', 'AllergenCrud');
            CRUD::resource('blessing-types', 'BlessingTypeCrud');
            CRUD::resource('cuisines', 'CuisineCrud');
            CRUD::resource('diets', 'DietCrud');
            CRUD::resource('holidays', 'HolidayCrud');
            CRUD::resource('ingredients', 'IngredientCrud');
            CRUD::resource('recipe-categories', 'RecipeCategoryCrud');
            CRUD::resource('sources', 'SourceCrud');
            CRUD::resource('tags', 'TagCrud');
            CRUD::resource('users', 'UserCrud');
            CRUD::resource('top-chefs', 'TopChefCrud');
            CRUD::resource('call-to-actions', 'CallToActionCrud');
            CRUD::resource('contact-submissions', 'SubmissionCrud');

            CRUD::resource('cms', 'PageCrud');
            CRUD::resource('article-categories', 'ArticleCategoryCrud');
            CRUD::resource('videos', 'VideoCrud');
            CRUD::resource('shows', 'ShowCrud');
            CRUD::resource('shows/{owner}/episodes', 'ShowEpisodeCrud');
            CRUD::resource('community-questions', 'GeneralQuestionCrud');
            CRUD::resource('community-questions/{owner}/answers', 'GeneralAnswerCrud');
            CRUD::resource('recipes/{owner}/reviews', 'ReviewCrud');
            CRUD::resource('reviews/{owner}/comments', 'ReviewCommentCrud');
            CRUD::resource('recipes/{owner}/questions', 'RecipeQuestionCrud');
            CRUD::resource('recipe-questions/{owner}/answers', 'RecipeAnswerCrud');
            CRUD::resource('articles/{owner}/comments', 'ArticleCommentCrud');
            CRUD::resource('article-comments/{owner}/replies', 'ArticleReplyCrud');
        });
    });

    Route::group(['middleware' => 'can:admin-full-access'], function () {
        Route::get('cms/pages/create', function () {
            return redirect()->route('flex.cms.pages_tree');
        })->name('flex.cms.pages.create');

        Route::get('cms/pages/edit/{pageId}', function () {
            return redirect()->route('flex.cms.pages_tree');
        })->name('flex.cms.pages.edit');
    });
});
