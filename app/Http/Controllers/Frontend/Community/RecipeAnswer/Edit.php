<?php

namespace App\Http\Controllers\Frontend\Community\RecipeAnswer;

use App\Http\Controllers\Controller;
use App\Models\RecipeAnswer;
use Assets;

/**
 * Class Edit
 * @package App\Http\Controllers\Frontend\Community\ArticleComment
 */
class Edit extends Controller
{
    /**
     * @param RecipeAnswer $item
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function __invoke(RecipeAnswer $item)
    {
        Assets::group('frontend')->addJs('community/delete.js');

        return view('community.recipe_answer.edit', compact('item'));
    }
}
