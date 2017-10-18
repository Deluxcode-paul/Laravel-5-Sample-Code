<?php

use App\Models\Article;
use App\Models\Show;
use App\Models\Video;
use App\Models\RecipeCategory;
use App\Models\Holiday;
use App\Models\Recipe;
use App\Models\User;
use App\Models\Review;
use App\Models\RecipeQuestion;
use App\Models\ArticleComment;
use App\Models\GeneralQuestion;

$sitemap_date = config('kosher.sitemap_date');

Route::get('sitemap.xml', function () {
    $sitemap = App::make("sitemap");

    $sitemap->setCache('laravel.sitemap-index', 3600);

    $sitemap->addSitemap(URL::to('sitemap-pages'));
    $sitemap->addSitemap(URL::to('sitemap-articles'));
    $sitemap->addSitemap(URL::to('sitemap-shows'));
    $sitemap->addSitemap(URL::to('sitemap-videos'));
    $sitemap->addSitemap(URL::to('sitemap-recipe-categories'));
    $sitemap->addSitemap(URL::to('sitemap-recipe-holidays'));
    $sitemap->addSitemap(URL::to('sitemap-recipes'));
    $sitemap->addSitemap(URL::to('sitemap-users'));
    $sitemap->addSitemap(URL::to('sitemap-recipe-reviews'));
    $sitemap->addSitemap(URL::to('sitemap-recipe-questions'));
    $sitemap->addSitemap(URL::to('sitemap-article-comments'));
    $sitemap->addSitemap(URL::to('sitemap-general-questions'));

    return $sitemap->render('sitemapindex');
});

Route::get('sitemap-pages', function () use ($sitemap_date) {
    $sitemap = App::make("sitemap");

    $sitemap->setCache('laravel.sitemap-pages', 3600);

    $sitemap->add(route('home'), $sitemap_date, '1.0', 'daily');
    $sitemap->add(route('community'), $sitemap_date, '1.0', 'daily');
    $sitemap->add(route('lifestyle'), $sitemap_date, '0.9', 'weekly');
    $sitemap->add(route('watch'), $sitemap_date, '0.9', 'weekly');
    $sitemap->add(route('generate-a-meal'), $sitemap_date, '0.8', 'monthly');
    $sitemap->add(route('contact'), $sitemap_date, '0.8', 'monthly');
    $sitemap->add(route('about.chefs'), $sitemap_date, '0.8', 'monthly');
    $sitemap->add(route('recipes.category'), $sitemap_date, '0.8', 'monthly');
    $sitemap->add(route('search.lifestyle'), $sitemap_date, '0.8', 'monthly');
    $sitemap->add(route('search.chef'), $sitemap_date, '0.8', 'monthly');
    $sitemap->add(route('search.watch'), $sitemap_date, '0.8', 'monthly');
    $sitemap->add(route('search.recipes'), $sitemap_date, '0.8', 'monthly');
    $sitemap->add(URL::to('/learn'), $sitemap_date, '0.8', 'monthly');
    $sitemap->add(URL::to('/about'), $sitemap_date, '0.8', 'monthly');
    $sitemap->add(URL::to('/terms'), $sitemap_date, '0.8', 'monthly');
    $sitemap->add(URL::to('/privacy'), $sitemap_date, '0.8', 'monthly');
    $sitemap->add(URL::to('/what-is-kosher'), $sitemap_date, '0.8', 'monthly');
    $sitemap->add(URL::to('/new-to-kosher'), $sitemap_date, '0.8', 'monthly');
    $sitemap->add(route('login'), $sitemap_date, '0.7', 'monthly');

    return $sitemap->render('xml');
});

Route::get('sitemap-articles', function () {
    $sitemap = App::make("sitemap");

    $sitemap->setCache('laravel.sitemap-articles', 3600);

    $articles = Article::published()
        ->orderBy('updated_at', 'desc')
        ->get();

    foreach ($articles as $article) {
        $sitemap->add($article->getUrl(), $article->updated_at, '0.9', 'monthly');
    }

    return $sitemap->render('xml');
});

Route::get('sitemap-shows', function () {
    $sitemap = App::make("sitemap");

    $sitemap->setCache('laravel.sitemap-shows', 3600);

    $shows = Show::orderBy('updated_at', 'desc')->get();

    foreach ($shows as $show) {
        $sitemap->add($show->getUrl(), $show->updated_at, '0.9', 'monthly');
    }

    return $sitemap->render('xml');
});

Route::get('sitemap-videos', function () {
    $sitemap = App::make("sitemap");

    $sitemap->setCache('laravel.sitemap-videos', 3600);

    $videos = Video::orderBy('updated_at', 'desc')->get();

    foreach ($videos as $video) {
        $sitemap->add($video->detailsUrl, $video->updated_at, '0.9', 'monthly');
    }

    return $sitemap->render('xml');
});

Route::get('sitemap-recipe-categories', function () use ($sitemap_date) {
    $sitemap = App::make("sitemap");

    $sitemap->setCache('laravel.sitemap-recipe-categories', 3600);

    $categories = RecipeCategory::all();

    foreach ($categories as $category) {
        $sitemap->add($category->getSubCategoryUrl(), $sitemap_date, '0.9', 'monthly');
    }

    return $sitemap->render('xml');
});

Route::get('sitemap-recipe-holidays', function () use ($sitemap_date) {
    $sitemap = App::make("sitemap");

    $sitemap->setCache('laravel.sitemap-recipe-holidays', 3600);

    $holidaysWithoutDate = Holiday::withoutDate()->get();

    $holidays = Holiday::nearest()->get();
    $holidays = $holidaysWithoutDate->merge($holidays);

    foreach ($holidays as $holiday) {
        $sitemap->add($holiday->getSubCategoryUrl(), $sitemap_date, '0.9', 'monthly');
    }

    return $sitemap->render('xml');
});

Route::get('sitemap-recipes', function () {
    $sitemap = App::make("sitemap");

    $sitemap->setCache('laravel.sitemap-recipes', 3600);

    $recipes = Recipe::orderBy('updated_at', 'desc')->get();

    foreach ($recipes as $recipe) {
        $sitemap->add($recipe->getUrl(), $recipe->updated_at, '0.9', 'weekly');
    }

    return $sitemap->render('xml');
});

Route::get('sitemap-users', function () {
    $sitemap = App::make("sitemap");

    $sitemap->setCache('laravel.sitemap-users', 3600);

    $users = User::orderBy('updated_at', 'desc')->get();

    foreach ($users as $user) {
        $sitemap->add($user->publicProfileUrl, $user->updated_at, '0.9', 'monthly');
    }

    return $sitemap->render('xml');
});

Route::get('sitemap-recipe-reviews', function () {
    $sitemap = App::make("sitemap");

    $sitemap->setCache('laravel.sitemap-recipe-reviews', 3600);

    $items = Review::orderBy('updated_at', 'desc')->get();

    foreach ($items as $item) {
        $sitemap->add($item->detailsUrl, $item->updated_at, '0.9', 'weekly');
    }

    return $sitemap->render('xml');
});

Route::get('sitemap-recipe-questions', function () {
    $sitemap = App::make("sitemap");

    $sitemap->setCache('laravel.sitemap-recipe-questions', 3600);

    $items = RecipeQuestion::orderBy('updated_at', 'desc')->get();

    foreach ($items as $item) {
        $sitemap->add($item->detailsUrl, $item->updated_at, '0.9', 'weekly');
    }

    return $sitemap->render('xml');
});

Route::get('sitemap-article-comments', function () {
    $sitemap = App::make("sitemap");

    $sitemap->setCache('laravel.sitemap-article-comments', 3600);

    $items = ArticleComment::orderBy('updated_at', 'desc')->get();

    foreach ($items as $item) {
        $sitemap->add($item->detailsUrl, $item->updated_at, '0.9', 'weekly');
    }

    return $sitemap->render('xml');
});


Route::get('sitemap-general-questions', function () {
    $sitemap = App::make("sitemap");

    $sitemap->setCache('laravel.sitemap-general-questions', 3600);

    $items = GeneralQuestion::orderBy('updated_at', 'desc')->get();

    foreach ($items as $item) {
        $sitemap->add($item->detailsUrl, $item->updated_at, '0.9', 'weekly');
    }

    return $sitemap->render('xml');
});
