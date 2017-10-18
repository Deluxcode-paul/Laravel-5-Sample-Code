<?php

namespace App\Observers\GeneralQuestion;

use DB;

/**
 * Class GeneralQuestionReportObserver
 */
class GeneralQuestionReportObserver
{
    /**
     * @param \App\Models\GeneralQuestionReport $model
     */
    public function saved($model)
    {
        DB::table('general_questions')
            ->where('id', $model->question_id)
            ->increment('reports');
    }

    /**
     * @param \App\Models\GeneralQuestionReport $model
     */
    public function deleted($model)
    {
        DB::table('general_questions')
            ->where('id', $model->question_id)
            ->decrement('reports');
    }
}
