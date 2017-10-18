<?php

namespace App\Observers\ArticleReply;

use DB;

/**
 * Class ArticleReplyVoteObserver
 */
class ArticleReplyVoteObserver
{
    /**
     * @param \App\Models\ArticleReplyVote $model
     */
    public function saved($model)
    {
        DB::table('article_replies')
            ->where('id', $model->article_reply_id)
            ->increment('votes');
    }

    /**
     * @param \App\Models\ArticleReplyVote $model
     */
    public function deleted($model)
    {
        DB::table('article_replies')
            ->where('id', $model->article_reply_id)
            ->decrement('votes');
    }
}
