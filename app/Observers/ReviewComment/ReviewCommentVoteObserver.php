<?php

namespace App\Observers\ReviewComment;

use DB;

/**
 * Class ReviewCommentVoteObserver
 */
class ReviewCommentVoteObserver
{
    /**
     * @param \App\Models\ReviewCommentVote $model
     */
    public function saved($model)
    {
        DB::table('review_comments')
            ->where('id', $model->review_comment_id)
            ->increment('votes');
    }

    /**
     * @param \App\Models\ReviewCommentVote $model
     */
    public function deleted($model)
    {
        DB::table('review_comments')
            ->where('id', $model->review_comment_id)
            ->decrement('votes');
    }
}
