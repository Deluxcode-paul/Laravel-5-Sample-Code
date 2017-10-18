<?php

namespace App\Observers\GeneralQuestion;

use DB;

/**
 * Class GeneralQuestionVoteObserver
 */
class GeneralQuestionVoteObserver
{
    /**
     * @param \App\Models\GeneralQuestionVote $model
     */
    public function saved($model)
    {
        DB::table('general_questions')
            ->where('id', $model->question_id)
            ->increment('votes');
    }

    /**
     * @param \App\Models\GeneralQuestionVote $model
     */
    public function deleted($model)
    {
        DB::table('general_questions')
            ->where('id', $model->question_id)
            ->decrement('votes');
    }
}
