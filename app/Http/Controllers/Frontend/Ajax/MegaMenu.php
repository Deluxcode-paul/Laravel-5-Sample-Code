<?php

namespace App\Http\Controllers\Frontend\Ajax;

use App\Http\Controllers\Controller;
use App\Models\RecipeCategory;
use App\Models\Holiday;

class MegaMenu extends Controller
{
    public function __invoke()
    {
        $categories = $this->getCategories();
        $holidays   = $this->getHolidays();

        $content = view('common.ajax.megamenu', compact('categories', 'holidays'))->render();

        return response()->json(compact('content'));
    }

    /**
     * @return mixed
     */
    protected function getCategories()
    {
        $megaMenu = RecipeCategory::megaMenu()
            ->random()
            ->take(config('kosher.pagination.mega_menu_categories'))
            ->get();

        if ($megaMenu->count() < config('kosher.pagination.mega_menu_categories')) {
            // Get is_featured categories
            $featured = RecipeCategory::featured()
                ->random()
                ->take((config('kosher.pagination.mega_menu_categories') - $megaMenu->count()))
                ->get();
            $megaMenu = $megaMenu->merge($featured);
        }

        if ($megaMenu->count() < config('kosher.pagination.mega_menu_categories')) {
            // Get common categories
            $common = RecipeCategory::notMegaMenu()
                ->notFeatured()
                ->random()
                ->take((config('kosher.pagination.mega_menu_categories') - $megaMenu->count()))
                ->get();
            $megaMenu = $megaMenu->merge($common);
        }

        return $megaMenu->shuffle();
    }

    /**
     * @return mixed
     */
    protected function getHolidays()
    {
        $holidaysWithoutDate = Holiday::withoutDate()
            ->take(config('kosher.pagination.mega_menu_holidays'))
            ->get();

        if ($holidaysWithoutDate->count() < config('kosher.pagination.mega_menu_holidays')) {
            $holidays = Holiday::nearest()
                ->take(config('kosher.pagination.mega_menu_holidays') - $holidaysWithoutDate->count())
                ->get();

            $holidaysWithoutDate = $holidaysWithoutDate->merge($holidays);
        }

        return $holidaysWithoutDate;
    }
}
