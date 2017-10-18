<?php

namespace App\Http\Controllers\Frontend\User\PublicProfile\Ajax;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Review;

/**
 * Class RecipeReviews
 * @package App\Http\Controllers\Frontend\User\PublicProfile\Ajax
 */
class RecipeReviews extends Controller
{
    /**
     * @param User $user
     * @return \Illuminate\Http\JsonResponse
     */
    public function __invoke(User $user)
    {
        $perPage = config('kosher.pagination.comments_public_profile');
        $recipeReviews = Review::forUser($user->id)
            ->recent()
            ->paginate($perPage);
        $content = view(
            'user.public_profile.view.comments.recipe_reviews.items',
            compact('recipeReviews')
        )->render();
        $hasMorePages = $recipeReviews->hasMorePages();

        return response()->json(compact('content', 'hasMorePages'));
    }
}
