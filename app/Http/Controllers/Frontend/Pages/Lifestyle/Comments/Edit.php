<?php

namespace App\Http\Controllers\Frontend\Pages\Lifestyle\Comments;

use App\Http\Controllers\Controller;
use App\Http\Traits\Community;
use App\Models\ArticleComment;
use Auth;

class Edit extends Controller
{
    use Community;

    /**
     * @param $articleId
     * @param $reviewId
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function __invoke($articleId, $reviewId)
    {
        $user = Auth::user();
        $comment = ArticleComment::findOrNew($reviewId);
        $comment->article_id = $articleId;
        $comment->user_id = isset($user->id) ? $user->id : 0;
        $tags = $this->getTags();
        $chefs = $this->getChefs();
        $content = view('pages.lifestyle.article.comments.form', compact('comment', 'tags', 'chefs'))->render();

        return response()->json(compact('content'));
    }
}
