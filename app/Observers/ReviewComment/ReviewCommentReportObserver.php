<?php

namespace App\Observers\ReviewComment;

use DB;

/**
 * Class ReviewCommentReportObserver
 */
class ReviewCommentReportObserver
{
    /**
     * @param \App\Models\ReviewCommentReport $model
     */
    public function saved($model)
    {
        DB::table('review_comments')
            ->where('id', $model->review_comment_id)
            ->increment('reports');
    }

    /**
     * @param \App\Models\ReviewCommentReport $model
     */
    public function deleted($model)
    {
        DB::table('review_comments')
            ->where('id', $model->review_comment_id)
            ->decrement('reports');
    }
}
