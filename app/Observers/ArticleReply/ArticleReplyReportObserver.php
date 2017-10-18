<?php

namespace App\Observers\ArticleReply;

use DB;

/**
 * Class ArticleReplyReportObserver
 */
class ArticleReplyReportObserver
{
    /**
     * @param \App\Models\ArticleReplyReport $model
     */
    public function saved($model)
    {
        DB::table('article_replies')
            ->where('id', $model->article_reply_id)
            ->increment('reports');
    }

    /**
     * @param \App\Models\ArticleReplyReport $model
     */
    public function deleted($model)
    {
        DB::table('article_replies')
            ->where('id', $model->article_reply_id)
            ->decrement('reports');
    }
}
