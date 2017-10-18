<?php

namespace App\Http\Controllers\Frontend\Recipes;

use App\Http\Controllers\Controller;
use App\Models\Recipe;
use App\Models\RecipeCategory;
use App\Models\Holiday;

class Category extends Controller
{
    public function __invoke()
    {
        $featuredCategories = $this->getFeaturedCategories();

        $allCategories = RecipeCategory::all();

        $commonCategories = $allCategories->diff($featuredCategories);

        $holidaysWithoutDate = Holiday::withoutDate()->get();

        $holidays = Holiday::nearest()->get();
        $holidays = $holidaysWithoutDate->merge($holidays);

        $featuredRecipes = Recipe::featured()
            ->mostPopular()
            ->take(config('kosher.pagination.featured_recipes'))
            ->get();

        return view('recipes.category', compact(
            'featuredCategories',
            'commonCategories',
            'holidays',
            'featuredRecipes'
        ));
    }

    /**
     * @return mixed
     */
    protected function getFeaturedCategories()
    {
        $featured = RecipeCategory::featured()
            ->random()
            ->take(config('kosher.pagination.featured_categories'))
            ->get();

        if ($featured->count() < config('kosher.pagination.featured_categories')) {
            $notFeatured = RecipeCategory::notFeatured()
                ->random()
                ->take((config('kosher.pagination.featured_categories') - $featured->count()))
                ->get();
            $featured = $featured->merge($notFeatured);
        }

        return $featured->shuffle();
    }
}
