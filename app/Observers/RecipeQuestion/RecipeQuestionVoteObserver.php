<?php

namespace App\Observers\RecipeQuestion;

use DB;

/**
 * Class RecipeQuestionVoteObserver
 */
class RecipeQuestionVoteObserver
{
    /**
     * @param \App\Models\RecipeQuestionVote $model
     */
    public function saved($model)
    {
        DB::table('recipe_questions')
            ->where('id', $model->recipe_question_id)
            ->increment('votes');
    }

    /**
     * @param \App\Models\RecipeQuestionVote $model
     */
    public function deleted($model)
    {
        DB::table('recipe_questions')
            ->where('id', $model->recipe_question_id)
            ->decrement('votes');
    }
}
