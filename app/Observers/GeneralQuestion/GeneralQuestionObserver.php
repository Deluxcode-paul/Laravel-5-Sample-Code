<?php

namespace App\Observers\GeneralQuestion;

use DB;

/**
 * Class GeneralQuestionObserver
 */
class GeneralQuestionObserver
{
    /**
     * @param \App\Models\GeneralQuestion $model
     */
    public function saving($model)
    {
        $model->activity_month = date('n');
        $model->activity_year  = date('Y');
    }

    /**
     * @param \App\Models\GeneralQuestion $model
     */
    public function deleting($model)
    {
        $model->tags()->sync([]);
        $model->chefs()->sync([]);
        $model->answers()->delete();

        DB::table('general_question_reports')
            ->where('question_id', $model->id)
            ->delete();

        DB::table('general_question_votes')
            ->where('question_id', $model->id)
            ->delete();
    }
}
