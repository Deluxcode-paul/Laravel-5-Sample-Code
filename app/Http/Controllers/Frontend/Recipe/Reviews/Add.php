<?php

namespace App\Http\Controllers\Frontend\Recipe\Reviews;

use App\Events\RecipeReview\RecipeReviewPosted;
use App\Http\Controllers\Controller;
use App\Http\Requests\Frontend\Community\RecipeReviewRequest;
use App\Models\Review;
use Auth;
use Mockery\Exception;

class Add extends Controller
{
    /**
     * @param $recipeId
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function __invoke(RecipeReviewRequest $request, $recipeId)
    {
        $content = '';
        $message = '';

        try {
            $user = Auth::user();

            $review = new Review();
            $review->recipe_id = $recipeId;
            $review->user_id = isset($user->id) ? $user->id : 0;

            $review->fill($request->only([
                'details',
                'title',
                'rating'
            ]));
            $review->save();

            if ($request->has('tags')) {
                $review->tags()->sync($request->get('tags'));
            }

            if ($request->has('chefs')) {
                $review->chefs()->sync($request->get('chefs'));
            }

            event(new RecipeReviewPosted($review));

            $review = Review::find($review->id);

            $content = view('community.blocks.items.item', ['item' => $review])->render();

        } catch (Exception $e) {
            $message = $e->getMessage();
        }
        return response()->json(compact('content', 'message'));
    }
}
