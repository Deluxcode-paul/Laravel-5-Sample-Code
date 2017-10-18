<?php

namespace App\Observers\RecipeAnswer;

use DB;

/**
 * Class RecipeAnswerObserver
 */
class RecipeAnswerObserver
{
    /**
     * @param \App\Models\RecipeAnswer $model
     */
    public function saved($model)
    {
        DB::table('recipe_questions')
            ->where('id', $model->recipe_question_id)
            ->increment('answers');

        $activity_dates = [
            'activity_month' => date('n'),
            'activity_year'  => date('Y')
        ];

        DB::table('recipe_questions')
            ->where('id', $model->recipe_question_id)
            ->update($activity_dates);
    }

    /**
     * @param \App\Models\RecipeAnswer $model
     */
    public function deleting($model)
    {
        DB::table('recipe_answer_reports')
            ->where('recipe_answer_id', $model->id)
            ->delete();

        DB::table('recipe_answer_votes')
            ->where('recipe_answer_id', $model->id)
            ->delete();
    }

    /**
     * @param \App\Models\RecipeAnswer $model
     */
    public function deleted($model)
    {
        DB::table('recipe_questions')
            ->where('id', $model->recipe_question_id)
            ->decrement('answers');
    }
}
