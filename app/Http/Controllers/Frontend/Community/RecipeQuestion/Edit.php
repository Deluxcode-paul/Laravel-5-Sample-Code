<?php

namespace App\Http\Controllers\Frontend\Community\RecipeQuestion;

use App\Http\Controllers\Frontend\Community\AbstractEdit;
use App\Models\RecipeQuestion;
use Assets;

/**
 * Class Edit
 * @package App\Http\Controllers\Frontend\Community\RecipeQuestion
 */
class Edit extends AbstractEdit
{
    /**
     * @param RecipeQuestion $item
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function __invoke(RecipeQuestion $item)
    {
        $this->item = $item;

        Assets::group('frontend')->addJs('community/delete.js');

        return view('community.recipe_question.edit', $this->getTemplateVariables());
    }
}
