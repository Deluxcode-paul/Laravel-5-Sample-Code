<?php

namespace App\Http\Controllers\Frontend\User\PublicProfile\Ajax;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Review;

/**
 * Class CommunityQuestions
 * @package App\Http\Controllers\Frontend\User\PublicProfile\Ajax
 */
class CommunityQuestions extends Controller
{
    /**
     * @param User $user
     * @return \Illuminate\Http\JsonResponse
     */
    public function __invoke(User $user)
    {
        $perPage = config('kosher.pagination.comments_public_profile');
        // TODO: implement Community Questions
        $communityQuestions = Review::forUser($user->id)
            ->recent()
            ->paginate($perPage);
        $content = view(
            'user.public_profile.view.comments.community_questions.items',
            compact('communityQuestions')
        )->render();
        $hasMorePages = $communityQuestions->hasMorePages();

        return response()->json(compact('content', 'hasMorePages'));
    }
}
