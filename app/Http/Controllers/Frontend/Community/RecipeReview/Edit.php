<?php

namespace App\Http\Controllers\Frontend\Community\RecipeReview;

use App\Http\Controllers\Frontend\Community\AbstractEdit;
use App\Models\Review;
use Assets;

/**
 * Class Edit
 * @package App\Http\Controllers\Frontend\Community\RecipeReview
 */
class Edit extends AbstractEdit
{
    /**
     * @param Review $item
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function __invoke(Review $item)
    {
        $this->item = $item;

        Assets::group('frontend')->addJs('community/delete.js');

        return view('community.recipe_review.edit', $this->getTemplateVariables());
    }
}
