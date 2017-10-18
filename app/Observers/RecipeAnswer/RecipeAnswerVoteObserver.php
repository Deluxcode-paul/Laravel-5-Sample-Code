<?php

namespace App\Observers\RecipeAnswer;

use DB;

/**
 * Class RecipeAnswerVoteObserver
 */
class RecipeAnswerVoteObserver
{
    /**
     * @param \App\Models\RecipeAnswerVote $model
     */
    public function saved($model)
    {
        DB::table('recipe_answers')
            ->where('id', $model->recipe_answer_id)
            ->increment('votes');
    }

    /**
     * @param \App\Models\RecipeAnswerVote $model
     */
    public function deleted($model)
    {
        DB::table('recipe_answers')
            ->where('id', $model->recipe_answer_id)
            ->decrement('votes');
    }
}
