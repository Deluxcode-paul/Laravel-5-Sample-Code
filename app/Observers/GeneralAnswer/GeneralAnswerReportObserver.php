<?php

namespace App\Observers\GeneralAnswer;

use DB;

/**
 * Class GeneralAnswerReportObserver
 */
class GeneralAnswerReportObserver
{
    /**
     * @param \App\Models\GeneralAnswerReport $model
     */
    public function saved($model)
    {
        DB::table('general_answers')
            ->where('id', $model->answer_id)
            ->increment('reports');
    }

    /**
     * @param \App\Models\GeneralAnswerReport $model
     */
    public function deleted($model)
    {
        DB::table('general_answers')
            ->where('id', $model->answer_id)
            ->decrement('reports');
    }
}
