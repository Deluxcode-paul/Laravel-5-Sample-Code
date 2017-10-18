<?php

namespace App\Http\Controllers\Frontend\Recipes;

use App\Http\Controllers\Frontend\AbstractRecipeSearch;

/**
 * Class ListGet
 * @package App\Http\Controllers\Frontend\Recipes
 */
class ListGet extends AbstractRecipeSearch
{
    protected $applyUserPreferences = true;

    /**
     * @param array $data
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    protected function render($data)
    {
        $data['labels'] = array_merge(trans('search/common'), trans('recipes/list'));

        return view('recipes.list', $data);
    }
}
