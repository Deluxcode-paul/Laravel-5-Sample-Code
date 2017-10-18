<?php

namespace App\Http\Controllers\Frontend\User\PublicProfile\Ajax;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\RecipeQuestion;

/**
 * Class RecipeQuestions
 * @package App\Http\Controllers\Frontend\User\PublicProfile\Ajax
 */
class RecipeQuestions extends Controller
{
    /**
     * @param User $user
     * @return \Illuminate\Http\JsonResponse
     */
    public function __invoke(User $user)
    {
        $perPage = config('kosher.pagination.comments_public_profile');
        $recipeQuestions = RecipeQuestion::forUser($user->id)
            ->recent()
            ->paginate($perPage);
        $content = view(
            'user.public_profile.view.comments.recipe_questions.items',
            compact('recipeQuestions')
        )->render();
        $hasMorePages = $recipeQuestions->hasMorePages();

        return response()->json(compact('content', 'hasMorePages'));
    }
}
