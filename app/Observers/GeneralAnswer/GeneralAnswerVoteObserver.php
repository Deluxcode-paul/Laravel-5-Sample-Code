<?php

namespace App\Observers\GeneralAnswer;

use DB;

/**
 * Class GeneralAnswerVoteObserver
 */
class GeneralAnswerVoteObserver
{
    /**
     * @param \App\Models\GeneralAnswerVote $model
     */
    public function saved($model)
    {
        DB::table('general_answers')
            ->where('id', $model->answer_id)
            ->increment('votes');
    }

    /**
     * @param \App\Models\GeneralAnswerVote $model
     */
    public function deleted($model)
    {
        DB::table('general_answers')
            ->where('id', $model->answer_id)
            ->decrement('votes');
    }
}
