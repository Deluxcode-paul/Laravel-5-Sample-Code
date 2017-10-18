<?php

namespace App\Http\Controllers\Frontend\Recipe\Reviews;

use App\Http\Controllers\Controller;
use App\Models\Recipe;
use DaveJamesMiller\Breadcrumbs\Exception;
use Illuminate\Http\Request;

class View extends Controller
{
    /**
     * @param $recipeId
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function __invoke($recipeId, Request $request)
    {
        $message = trans('recipe/review.error_update_review');
        $content = '';
        $hasMorePages = '';
        $link ='';
        try {
            $recipe = Recipe::find($recipeId);
            $reviewsPage = $recipe->getReviewsPage();
            $content = view('recipe.blocks.reviews.list', compact('reviewsPage'))->render();
            $hasMorePages = $reviewsPage->hasMorePages();
            $link = route('recipe.reviews.view', [$recipeId]).  "?page=" . ($reviewsPage->currentPage() + 1);
        } catch (Exception $e) {
            $message = $e->getMessage();
        }
        return response()->json(compact('content', 'hasMorePages', 'message', 'link'));
    }
}
