<?php

// Home
Breadcrumbs::register('home', function ($breadcrumbs) {
    $breadcrumbs->push(trans('breadcrumbs.home'), route('home'));
});

// Home > Recipes
Breadcrumbs::register('recipes.category', function ($breadcrumbs) {
    $breadcrumbs->parent('home');
    $breadcrumbs->push(trans('breadcrumbs.recipes'), route('recipes.category'));
});

// Home > Recipes > Subcategory
Breadcrumbs::register('recipes.subcategory', function ($breadcrumbs, $title) {
    $breadcrumbs->parent('home');
    $breadcrumbs->push(trans('breadcrumbs.recipes'), route('recipes.category'));
    $breadcrumbs->push($title, route('recipes.list'));
});

// Home > Recipes > [Recipe]
Breadcrumbs::register('recipe', function ($breadcrumbs, $recipe) {
    $breadcrumbs->parent('recipes.category');
    $breadcrumbs->push(KosherHelper::trimForBreadcrumbs($recipe->title, 80), $recipe->getUrl());
});

// Home > Generate a Meal
Breadcrumbs::register('generate-a-meal', function ($breadcrumbs) {
    $breadcrumbs->parent('home');
    $breadcrumbs->push(trans('breadcrumbs.generate_a_meal'), route('generate-a-meal'));
});

// Home > Watch
Breadcrumbs::register('watch', function ($breadcrumbs) {
    $breadcrumbs->parent('home');
    $breadcrumbs->push(trans('breadcrumbs.watch'), route('watch'));
});

// Home > Watch > [Show]
Breadcrumbs::register('show', function ($breadcrumbs, $show) {
    $breadcrumbs->parent('watch');
    $breadcrumbs->push($show->title, route('watch.show', $show->id));
});

// Home > Watch > [Video]
Breadcrumbs::register('video', function ($breadcrumbs, $video) {
    $breadcrumbs->parent($video->owner->getBreadcrumb(), $video->owner);
    $breadcrumbs->push(KosherHelper::trimForBreadcrumbs($video->title, 80), route('watch.video', $video->id));
});

// Home > Your Profile
Breadcrumbs::register('user.profile', function ($breadcrumbs) {
    $breadcrumbs->parent('home');
    $breadcrumbs->push(trans('breadcrumbs.profile'), route('user.profile.account.view'));
});

// Home > Your Profile > Activity
Breadcrumbs::register('user.activity', function ($breadcrumbs) {
    $breadcrumbs->parent('user.profile');
    $breadcrumbs->push(trans('breadcrumbs.activity'), route('user.profile.activity.recipe-questions'));
});
Breadcrumbs::register('user.activity.recipe-questions', function ($breadcrumbs) {
    $breadcrumbs->parent('user.activity');
    $breadcrumbs->push(trans('breadcrumbs.recipe-questions'), route('user.profile.activity.recipe-questions'));
});
Breadcrumbs::register('user.activity.recipe-reviews', function ($breadcrumbs) {
    $breadcrumbs->parent('user.activity');
    $breadcrumbs->push(trans('breadcrumbs.recipe-reviews'), route('user.profile.activity.recipe-reviews'));
});
Breadcrumbs::register('user.activity.article-comments', function ($breadcrumbs) {
    $breadcrumbs->parent('user.activity');
    $breadcrumbs->push(trans('breadcrumbs.article-comments'), route('user.profile.activity.article-comments'));
});
Breadcrumbs::register('user.activity.community-questions', function ($breadcrumbs) {
    $breadcrumbs->parent('user.activity');
    $breadcrumbs->push(trans('breadcrumbs.community-questions'), route('user.profile.activity.community-questions'));
});

// Home > Your Profile > Account Information
Breadcrumbs::register('user.account', function ($breadcrumbs) {
    $breadcrumbs->parent('user.profile');
    $breadcrumbs->push(trans('breadcrumbs.account'), route('user.profile.account.view'));
});

// Home > Your Profile > Recipe Box
Breadcrumbs::register('user.recipe-box', function ($breadcrumbs) {
    $breadcrumbs->parent('user.profile');
    $breadcrumbs->push(trans('breadcrumbs.recipe_box'), route('user.profile.recipe-box.view'));
});

// Home > Your Profile > My Recipes
Breadcrumbs::register('user.my-recipes', function ($breadcrumbs) {
    $breadcrumbs->parent('user.profile');
    $breadcrumbs->push(trans('breadcrumbs.my_recipes'), route('user.profile.my-recipes.view'));
});

// Home > Your Profile > My Articles
Breadcrumbs::register('user.my-articles', function ($breadcrumbs) {
    $breadcrumbs->parent('user.profile');
    $breadcrumbs->push(trans('breadcrumbs.my_articles'), route('user.profile.my-articles.view'));
});

// Home > Your Profile > Shopping Lists
Breadcrumbs::register('user.shopping-lists', function ($breadcrumbs) {
    $breadcrumbs->parent('user.profile');
    $breadcrumbs->push(trans('breadcrumbs.shopping_lists'), route('user.profile.shopping-lists.view'));
});

// Home > About
Breadcrumbs::register('about', function ($breadcrumbs) {
    $breadcrumbs->parent('home');
    $breadcrumbs->push(trans('breadcrumbs.about'), url('/about'));
});

// Home > About > Chefs
Breadcrumbs::register('about.chefs', function ($breadcrumbs) {
    $breadcrumbs->parent('about');
    $breadcrumbs->push(trans('breadcrumbs.chefs'), route('about.chefs'));
});

// Home > About > Chefs > [Chef]
Breadcrumbs::register('chef', function ($breadcrumbs, $user) {
    $breadcrumbs->parent('about.chefs');
    $breadcrumbs->push('Chef '.$user->fullName, route('user.view', $user->id));
});

// Home > Lifestyle
Breadcrumbs::register('lifestyle', function ($breadcrumbs) {
    $breadcrumbs->parent('home');
    $breadcrumbs->push(trans('breadcrumbs.lifestyle'), route('lifestyle'));
});

// Home > Lifestyle > [Article]
Breadcrumbs::register('article', function ($breadcrumbs, $article) {
    $breadcrumbs->parent('lifestyle');
    $breadcrumbs->push(KosherHelper::trimForBreadcrumbs($article->title, 80), $article->getUrl());
});

// Home > Contact Us
Breadcrumbs::register('contact', function ($breadcrumbs) {
    $breadcrumbs->parent('home');
    $breadcrumbs->push(trans('breadcrumbs.contact'), route('contact'));
});

// Frontend CMS pages
Breadcrumbs::register('cms', function ($breadcrumbs, $urls = []) {
    $breadcrumbs->parent('home');
    foreach ($urls as $url) {
        $breadcrumbs->push(KosherHelper::trimForBreadcrumbs($url['title'], 80), $url['url']);
    }
});

// Home > Community
Breadcrumbs::register('community', function ($breadcrumbs) {
    $breadcrumbs->parent('home');
    $breadcrumbs->push(trans('breadcrumbs.community'), route('community'));
});
Breadcrumbs::register('community.ask-question', function ($breadcrumbs) {
    $breadcrumbs->parent('community');
    $breadcrumbs->push(trans('breadcrumbs.community-ask-question'), route('community.ask-question'));
});
Breadcrumbs::register('recipe-review', function ($breadcrumbs, $item) {
    $breadcrumbs->parent('community');
    $breadcrumbs->push($item->title, route('community.recipe-review', $item->id));
});
Breadcrumbs::register('recipe-question', function ($breadcrumbs, $item) {
    $breadcrumbs->parent('community');
    $breadcrumbs->push($item->title, route('community.recipe-question', $item->id));
});
Breadcrumbs::register('article-comment', function ($breadcrumbs, $item) {
    $breadcrumbs->parent('community');
    $breadcrumbs->push($item->title, route('community.article-comment', $item->id));
});
Breadcrumbs::register('community-question', function ($breadcrumbs, $item) {
    $breadcrumbs->parent('community');
    $breadcrumbs->push($item->title, route('community.community-question', $item->id));
});

// Maintenance
Breadcrumbs::register('maintenance', function ($breadcrumbs) {
    $breadcrumbs->parent('home');
    $breadcrumbs->push(trans('breadcrumbs.maintenance'), route('maintenance'));
});

// Backpack CRUD
Breadcrumbs::register('crud', function ($breadcrumbs, $urls = []) {
    $breadcrumbs->push(trans('backpack::crud.admin'), url(config('backpack.base.route_prefix'), 'dashboard'));
    foreach ($urls as $url) {
        $breadcrumbs->push($url['title'], $url['url']);
    }
});

// Admin CMS pages
Breadcrumbs::register('cmsPages', function ($breadcrumbs, $urls = []) {
    $breadcrumbs->push(trans('backpack::crud.admin'), url(config('backpack.base.route_prefix'), 'dashboard'));
    $breadcrumbs->push('Cms Pages', url('admin/cms'));
    foreach ($urls as $url) {
        $breadcrumbs->push($url['title'], $url['url']);
    }
});

// Errors
Breadcrumbs::register('errors', function ($breadcrumbs, $urls = []) {
    $breadcrumbs->parent('home');
    foreach ($urls as $url) {
        $breadcrumbs->push($url['title'], $url['url']);
    }
});
