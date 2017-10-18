<?php

namespace App\Observers\RecipeQuestion;

use DB;

/**
 * Class RecipeQuestionObserver
 */
class RecipeQuestionReportObserver
{
    /**
     * @param \App\Models\RecipeQuestionReport $model
     */
    public function saved($model)
    {
        DB::table('recipe_questions')
            ->where('id', $model->recipe_question_id)
            ->increment('reports');
    }

    /**
     * @param \App\Models\RecipeQuestionReport $model
     */
    public function deleted($model)
    {
        DB::table('recipe_questions')
            ->where('id', $model->recipe_question_id)
            ->decrement('reports');
    }
}
