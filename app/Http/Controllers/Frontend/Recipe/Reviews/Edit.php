<?php

namespace App\Http\Controllers\Frontend\Recipe\Reviews;

use App\Http\Controllers\Controller;
use App\Http\Traits\Community;
use App\Models\Review;
use Illuminate\Http\Request;
use Auth;

class Edit extends Controller
{
    use Community;

    /**
     * @param $recipeId
     * @param $reviewId
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function __invoke($recipeId, $reviewId, Request $request)
    {
        $user = Auth::user();
        $review = Review::findOrNew($reviewId);
        $review->recipe_id = $recipeId;
        $review->user_id = isset($user->id) ? $user->id : 0;
        $tags = $this->getTags();
        $chefs = $this->getChefs();
        $content = view('recipe.blocks.reviews.form', compact('review', 'tags', 'chefs'))->render();

        return response()->json(compact('content'));
    }
}
