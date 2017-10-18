<?php

namespace App\Observers\ArticleReply;

use DB;

/**
 * Class ArticleReplyObserver
 */
class ArticleReplyObserver
{
    /**
     * @param \App\Models\ArticleReply $model
     */
    public function saved($model)
    {
        DB::table('article_comments')
            ->where('id', $model->article_comment_id)
            ->increment('replies');

        $activity_dates = [
            'activity_month' => date('n'),
            'activity_year'  => date('Y')
        ];

        DB::table('article_comments')
            ->where('id', $model->article_comment_id)
            ->update($activity_dates);
    }

    /**
     * @param \App\Models\ArticleReply $model
     */
    public function deleting($model)
    {
        DB::table('article_reply_reports')
            ->where('article_reply_id', $model->id)
            ->delete();

        DB::table('article_reply_votes')
            ->where('article_reply_id', $model->id)
            ->delete();
    }

    /**
     * @param \App\Models\ArticleReply $model
     */
    public function deleted($model)
    {
        DB::table('article_comments')
            ->where('id', $model->article_comment_id)
            ->decrement('replies');
    }
}
