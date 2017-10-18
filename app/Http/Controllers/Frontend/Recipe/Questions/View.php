<?php

namespace App\Http\Controllers\Frontend\Recipe\Questions;

use App\Http\Controllers\Controller;
use App\Models\Recipe;
use App\Models\RecipeQuestion;
use DaveJamesMiller\Breadcrumbs\Exception;
use Illuminate\Http\Request;
use Auth;

class View extends Controller
{
    /**
     * @param $recipeId
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function __invoke($recipeId, Request $request)
    {
        $message = trans('recipe/questions.error_update_question');
        $content = '';
        $hasMorePages = '';
        $link ='';
        try {
            $recipe = Recipe::find($recipeId);

            $questionsPage = $recipe->getQuestionsPage();

            $content = view('recipe.blocks.questions.list', compact('questionsPage'))->render();
            $hasMorePages = $questionsPage->hasMorePages();
            $link = route('recipe.questions.view', [$recipeId]).  "?page=" . ($questionsPage->currentPage() + 1);
        } catch (Exception $e) {
            $message = $e->getMessage();
        }
        return response()->json(compact('content', 'hasMorePages', 'message', 'link'));
    }
}
