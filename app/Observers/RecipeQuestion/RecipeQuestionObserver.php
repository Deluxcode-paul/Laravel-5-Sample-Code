<?php

namespace App\Observers\RecipeQuestion;

use DB;

/**
 * Class RecipeQuestionObserver
 */
class RecipeQuestionObserver
{
    /**
     * @param \App\Models\RecipeQuestion $model
     */
    public function saving($model)
    {
        $model->activity_month = date('n');
        $model->activity_year  = date('Y');
    }

    /**
     * @param \App\Models\RecipeQuestion $model
     */
    public function deleting($model)
    {
        $model->tags()->sync([]);
        $model->chefs()->sync([]);
        $model->answers()->delete();

        DB::table('recipe_question_reports')
            ->where('recipe_question_id', $model->id)
            ->delete();

        DB::table('recipe_question_reports')
            ->where('recipe_question_id', $model->id)
            ->delete();
    }
}
