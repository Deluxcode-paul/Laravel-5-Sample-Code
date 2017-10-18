<?php

namespace App\Http\Controllers\Frontend\Pages\Lifestyle\Comments;

use App\Events\ArticleComment\ArticleCommentPosted;
use App\Http\Controllers\Controller;
use App\Http\Requests\Frontend\Community\ArticleCommentRequest;
use App\Models\ArticleComment;
use Illuminate\Http\Request;
use Auth;
use Mockery\Exception;

class Add extends Controller
{
    /**
     * @param $article_id
     * @param ArticleCommentRequest $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function __invoke(ArticleCommentRequest $request, $article_id)
    {
        $content = '';
        $message = '';

        try {
            $user = Auth::user();

            $comment = new ArticleComment();
            $comment->article_id = $article_id;
            $comment->user_id = isset($user->id) ? $user->id : 0;

            $comment->fill($request->only([
                'details',
                'title'
            ]));

            $comment->save();

            if ($request->has('tags')) {
                $comment->tags()->sync($request->get('tags'));
            }

            if ($request->has('chefs')) {
                $comment->chefs()->sync($request->get('chefs'));
            }

            $comment = ArticleComment::find($comment->id);

            event(new ArticleCommentPosted($comment));

            $content = view('community.blocks.items.item', ['item' => $comment])->render();

        } catch (Exception $e) {
            $message = $e->getMessage();
        }
        return response()->json(compact('content', 'message'));
    }
}
