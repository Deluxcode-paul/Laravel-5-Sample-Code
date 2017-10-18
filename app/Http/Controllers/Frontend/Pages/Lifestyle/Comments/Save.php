<?php

namespace App\Http\Controllers\Frontend\Pages\Lifestyle\Comments;

use App\Http\Controllers\Controller;
use App\Models\ArticleComment;
use Illuminate\Http\Request;
use Mockery\Exception;

class Save extends Controller
{
    /**
     * @param $articleId
     * @param $commentId
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function __invoke($articleId, $commentId, Request $request)
    {
        $content = '';
        $message = '';

        try {
            $comment = ArticleComment::find($commentId);
            $comment->article_id  = $articleId;
            $comment->fill($request->only([
                'title',
                'details',
                'rating'
            ]));
            $comment->save();

            if ($request->has('tags')) {
                $comment->tags()->sync($request->get('tags'));
            }

            if ($request->has('chefs')) {
                $comment->chefs()->sync($request->get('chefs'));
            }

            $content = view('pages.lifestyle.article.comments.comment', compact('comment'))->render();
        } catch (Exception $e) {
            $message = $e->getMessage();
        }
        return response()->json(compact('content', 'message'));
    }
}
