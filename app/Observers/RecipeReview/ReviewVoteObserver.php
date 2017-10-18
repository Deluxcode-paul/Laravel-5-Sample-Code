<?php

namespace App\Observers\RecipeReview;

use DB;

/**
 * Class ReviewVoteObserver
 */
class ReviewVoteObserver
{
    /**
     * @param \App\Models\ReviewVote $model
     */
    public function saved($model)
    {
        DB::table('reviews')
            ->where('id', $model->review_id)
            ->increment('votes');
    }

    /**
     * @param \App\Models\ReviewVote $model
     */
    public function deleted($model)
    {
        DB::table('reviews')
            ->where('id', $model->review_id)
            ->decrement('votes');
    }
}
