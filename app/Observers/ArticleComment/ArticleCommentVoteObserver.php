<?php

namespace App\Observers\ArticleComment;

use DB;

/**
 * Class ArticleCommentVoteObserver
 */
class ArticleCommentVoteObserver
{
    /**
     * @param \App\Models\ArticleCommentVote $model
     */
    public function saved($model)
    {
        DB::table('article_comments')
            ->where('id', $model->article_comment_id)
            ->increment('votes');
    }

    /**
     * @param \App\Models\ArticleCommentVote $model
     */
    public function deleted($model)
    {
        DB::table('article_comments')
            ->where('id', $model->article_comment_id)
            ->decrement('votes');
    }
}
