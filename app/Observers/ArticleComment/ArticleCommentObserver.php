<?php

namespace App\Observers\ArticleComment;

use DB;

/**
 * Class ArticleCommentObserver
 */
class ArticleCommentObserver
{
    /**
     * @param \App\Models\ArticleComment $model
     */
    public function saving($model)
    {
        $model->activity_month = date('n');
        $model->activity_year  = date('Y');
    }

    /**
     * @param \App\Models\ArticleComment $model
     */
    public function deleting($model)
    {
        $model->tags()->sync([]);
        $model->chefs()->sync([]);
        $model->replies()->delete();

        DB::table('article_comment_reports')
            ->where('article_comment_id', $model->id)
            ->delete();

        DB::table('article_comment_votes')
            ->where('article_comment_id', $model->id)
            ->delete();
    }
}
