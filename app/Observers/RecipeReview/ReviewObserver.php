<?php

namespace App\Observers\RecipeReview;

use DB;

/**
 * Class ReviewObserver
 */
class ReviewObserver
{
    /**
     * @param \App\Models\Review $model
     */
    public function saving($model)
    {
        $model->activity_month = date('n');
        $model->activity_year  = date('Y');
    }

    /**
     * @param \App\Models\Review $model
     */
    public function saved($model)
    {
        $this->updateRecipeRating($model);
    }

    /**
     * @param \App\Models\Review $model
     */
    public function deleting($model)
    {
        $model->tags()->sync([]);
        $model->chefs()->sync([]);
        $model->comments()->delete();

        DB::table('review_reports')
            ->where('review_id', $model->id)
            ->delete();

        DB::table('review_votes')
            ->where('review_id', $model->id)
            ->delete();
    }

    /**
     * @param \App\Models\Review $model
     */
    public function deleted($model)
    {
        $this->updateRecipeRating($model);
    }

    /**
     * @param \App\Models\Review $model
     */
    private function updateRecipeRating($model)
    {
        $rating = collect();
        foreach ($model->recipe->reviews as $review) {
            $rating->push($review->rating);
        }

        DB::table('recipes')
            ->where('id', $model->recipe_id)
            ->update(['rating' => floor($rating->avg())]);
    }
}
