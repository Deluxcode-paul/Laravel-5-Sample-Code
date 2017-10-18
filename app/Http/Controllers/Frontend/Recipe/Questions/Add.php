<?php

namespace App\Http\Controllers\Frontend\Recipe\Questions;

use App\Events\RecipeQuestion\RecipeQuestionPosted;
use App\Http\Controllers\Controller;
use App\Http\Requests\Frontend\Community\RecipeQuestionRequest;
use App\Models\RecipeQuestion;
use Illuminate\Http\Request;
use Auth;
use Mockery\Exception;

class Add extends Controller
{
    /**
     * @param $recipeId
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function __invoke(RecipeQuestionRequest $request, $recipeId)
    {
        $content = '';
        $message = '';

        try {
            $user = Auth::user();

            $question = new RecipeQuestion();
            $question->recipe_id = $recipeId;
            $question->user_id = isset($user->id) ? $user->id : 0;

            $question->fill($request->only([
                'details',
                'title'
            ]));
            $question->save();

            if ($request->has('tags')) {
                $question->tags()->sync($request->get('tags'));
            }

            if ($request->has('chefs')) {
                $question->chefs()->sync($request->get('chefs'));
            }

            event(new RecipeQuestionPosted($question));

            $question = RecipeQuestion::find($question->id);

            $content = view('community.blocks.items.item', ['item' => $question])->render();
        } catch (Exception $e) {
            $message = $e->getMessage();
        }

        return response()->json(compact('content', 'message'));
    }
}
