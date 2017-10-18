<?php

namespace App\Http\Controllers\Frontend\User\Profile\Activity\Ajax\Reply;

use App\Events\ArticleReply\ArticleReplyPosted;
use App\Http\Controllers\Frontend\User\Profile\AbstractProfile;
use App\Http\Requests\Frontend\User\Profile\Activity\Reply\ArticleCommentRequest;
use App\Models\ArticleReply;
use App\Models\ArticleComment as ArticleCommentModel;

class ArticleComment extends AbstractProfile
{
    /**
     * @param ArticleCommentRequest $request
     * @param ArticleCommentModel $comment
     * @return \Illuminate\Http\JsonResponse
     */
    public function __invoke(ArticleCommentRequest $request, ArticleCommentModel $comment)
    {
        $item = new ArticleReply();
        $item->user_id = $this->currentUser->id;
        $item->article_comment_id = $comment->id;
        $item->fill($request->only([
            'details'
        ]));
        $item->save();

        event(new ArticleReplyPosted($item));

        $content = view('community.blocks.items.reply_ajax', compact('item'))->render();

        return response()->json(compact('content'));
    }
}
