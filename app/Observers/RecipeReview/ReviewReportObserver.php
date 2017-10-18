<?php

namespace App\Observers\RecipeReview;

use DB;

/**
 * Class ReviewReportObserver
 */
class ReviewReportObserver
{
    /**
     * @param \App\Models\ReviewReport $model
     */
    public function saved($model)
    {
        DB::table('reviews')
            ->where('id', $model->review_id)
            ->increment('reports');
    }

    /**
     * @param \App\Models\ReviewReport $model
     */
    public function deleted($model)
    {
        DB::table('reviews')
            ->where('id', $model->review_id)
            ->decrement('reports');
    }
}
