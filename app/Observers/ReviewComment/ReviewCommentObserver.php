<?php

namespace App\Observers\ReviewComment;

use DB;

/**
 * Class ReviewCommentObserver
 */
class ReviewCommentObserver
{
    /**
     * @param \App\Models\ReviewComment $model
     */
    public function saved($model)
    {
        DB::table('reviews')
            ->where('id', $model->review_id)
            ->increment('comments');

        $activity_dates = [
            'activity_month' => date('n'),
            'activity_year'  => date('Y')
        ];

        DB::table('reviews')
            ->where('id', $model->review_id)
            ->update($activity_dates);
    }

    /**
     * @param \App\Models\ReviewComment $model
     */
    public function deleting($model)
    {
        DB::table('review_comment_reports')
            ->where('review_comment_id', $model->id)
            ->delete();

        DB::table('review_comment_votes')
            ->where('review_comment_id', $model->id)
            ->delete();
    }

    /**
     * @param \App\Models\ReviewComment $model
     */
    public function deleted($model)
    {
        DB::table('reviews')
            ->where('id', $model->review_id)
            ->decrement('comments');
    }
}
