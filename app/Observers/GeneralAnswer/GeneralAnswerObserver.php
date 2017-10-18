<?php

namespace App\Observers\GeneralAnswer;

use DB;

/**
 * Class GeneralAnswerObserver
 */
class GeneralAnswerObserver
{
    /**
     * @param \App\Models\GeneralAnswer $model
     */
    public function saved($model)
    {
        DB::table('general_questions')
            ->where('id', $model->question_id)
            ->increment('answers');

        $activity_dates = [
            'activity_month' => date('n'),
            'activity_year'  => date('Y')
        ];

        DB::table('general_questions')
            ->where('id', $model->question_id)
            ->update($activity_dates);
    }

    /**
     * @param \App\Models\GeneralAnswer $model
     */
    public function deleting($model)
    {
        DB::table('general_answer_reports')
            ->where('answer_id', $model->id)
            ->delete();

        DB::table('general_answer_votes')
            ->where('answer_id', $model->id)
            ->delete();
    }

    /**
     * @param \App\Models\GeneralAnswer $model
     */
    public function deleted($model)
    {
        DB::table('general_questions')
            ->where('id', $model->question_id)
            ->decrement('answers');
    }
}
