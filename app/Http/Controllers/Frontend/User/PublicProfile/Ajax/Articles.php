<?php

namespace App\Http\Controllers\Frontend\User\PublicProfile\Ajax;

use App\Http\Controllers\Controller;
use App\Models\User;

class Articles extends Controller
{
    public function __invoke(User $user)
    {
        $perPage = config('kosher.pagination.articles_public_profile');
        $articles = $user->articles()
            ->published()
            ->recent()
            ->paginate($perPage);
        $content = view('user.public_profile.view.articles.items', compact('articles'))->render();
        $hasMorePages = $articles->hasMorePages();

        return response()->json(compact('content', 'hasMorePages'));
    }
}
