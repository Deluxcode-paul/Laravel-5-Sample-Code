<?php

namespace App\Http\Controllers\Frontend\User\PublicProfile\Ajax;

use App\Http\Controllers\Controller;
use App\Models\User;

/**
 * Class Videos
 * @package App\Http\Controllers\Frontend\User\PublicProfile\Ajax
 */
class Videos extends Controller
{
    /**
     * @param User $user
     * @return \Illuminate\Http\JsonResponse
     */
    public function __invoke(User $user)
    {
        $perPage = config('kosher.pagination.videos_public_profile');
        $videos = $user->queryChefVideos()->recent()->paginate($perPage);
        $content = view('user.public_profile.view.videos.items', compact('videos'))->render();
        $hasMorePages = $videos->hasMorePages();

        return response()->json(compact('content', 'hasMorePages'));
    }
}
