<?php

namespace App\Observers\ArticleComment;

use DB;

/**
 * Class ArticleCommentReportObserver
 */
class ArticleCommentReportObserver
{
    /**
     * @param \App\Models\ArticleCommentReport $model
     */
    public function saved($model)
    {
        DB::table('article_comments')
            ->where('id', $model->article_comment_id)
            ->increment('reports');
    }

    /**
     * @param \App\Models\ArticleCommentReport $model
     */
    public function deleted($model)
    {
        DB::table('recipe_questions')
            ->where('id', $model->article_comment_id)
            ->decrement('reports');
    }
}
