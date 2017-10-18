<?php

namespace App\Http\Controllers\Frontend\Recipe\Questions;

use App\Http\Controllers\Controller;
use App\Http\Traits\Community;
use App\Models\RecipeQuestion;
use Illuminate\Http\Request;
use Auth;

class Edit extends Controller
{
    use Community;

    /**
     * @param $recipeId
     * @param $questionId
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function __invoke($recipeId, $questionId, Request $request)
    {
        $user = Auth::user();
        $question = RecipeQuestion::findOrNew($questionId);
        $question->recipe_id = $recipeId;
        $question->user_id = isset($user->id) ? $user->id : 0;
        $tags = $this->getTags();
        $chefs = $this->getChefs();
        $content = view('recipe.blocks.questions.form', compact('question', 'tags', 'chefs'))->render();

        return response()->json(compact('content'));
    }
}
