<?php

namespace App\Http\Controllers\Frontend\Recipe\Questions;

use App\Http\Controllers\Controller;
use App\Models\RecipeQuestion;
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
            $question = RecipeQuestion::find($reviewId);

            $question->recipe_id = $recipeId;
            $question->fill($request->only([
                'title',
                'details',
                'rating'
            ]));
            $question->save();

            if ($request->has('tags')) {
                $question->tags()->sync($request->get('tags'));
            }

            if ($request->has('chefs')) {
                $question->chefs()->sync($request->get('chefs'));
            }

            $content = view('recipe.blocks.questions.question', compact('question'))->render();
        } catch (Exception $e) {
            $message = $e->getMessage();
        }

        return response()->json(compact('content', 'message'));
    }
}
