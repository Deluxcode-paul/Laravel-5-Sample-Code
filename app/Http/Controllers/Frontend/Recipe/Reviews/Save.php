<?php

namespace App\Http\Controllers\Frontend\Recipe\Reviews;

use App\Http\Controllers\Controller;
use App\Models\Review;
use Illuminate\Http\Request;
use Mockery\Exception;

class Save extends Controller
{
    /**
     * @param $recipeId
     * @param $reviewId
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function __invoke($recipeId, $reviewId, Request $request)
    {
        $content = '';
        $message = '';

        try {
            $review = Review::find($reviewId);
            $review->recipe_id = $recipeId;
            $review->fill($request->only([
                'title',
                'details',
                'rating'
            ]));
            $review->save();

            if ($request->has('tags')) {
                $review->tags()->sync($request->get('tags'));
            }

            if ($request->has('chefs')) {
                $review->chefs()->sync($request->get('chefs'));
            }

            $content = view('recipe.blocks.reviews.review', compact('review'))->render();
        } catch (Exception $e) {
            $message = $e->getMessage();
        }
        return response()->json(compact('content', 'message'));
    }
}
