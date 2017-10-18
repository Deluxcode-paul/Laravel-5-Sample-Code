<?php

namespace App\Http\Controllers\Frontend\User\PublicProfile\Ajax;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Review;

/**
 * Class ArticleComments
 * @package App\Http\Controllers\Frontend\User\PublicProfile\Ajax
 */
class ArticleComments extends Controller
{
    /**
     * @param User $user
     * @return \Illuminate\Http\JsonResponse
     */
    public function __invoke(User $user)
    {
        $perPage = config('kosher.pagination.comments_public_profile');
        // TODO: implement Article Comments
        $articleComments = Review::forUser($user->id)
            ->recent()
            ->paginate($perPage);
        $content = view(
            'user.public_profile.view.comments.article_comments.items',
            compact('articleComments')
        )->render();
        $hasMorePages = $articleComments->hasMorePages();

        return response()->json(compact('content', 'hasMorePages'));
    }
}
