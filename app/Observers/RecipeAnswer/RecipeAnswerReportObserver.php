<?php

namespace App\Observers\RecipeAnswer;

use DB;

/**
 * Class RecipeAnswerObserver
 */
class RecipeAnswerReportObserver
{
    /**
     * @param \App\Models\RecipeAnswerReport $model
     */
    public function saved($model)
    {
        DB::table('recipe_answers')
            ->where('id', $model->recipe_answer_id)
            ->increment('reports');
    }

    /**
     * @param \App\Models\RecipeAnswerReport $model
     */
    public function deleted($model)
    {
        DB::table('recipe_answers')
            ->where('id', $model->recipe_answer_id)
            ->decrement('reports');
    }
}
