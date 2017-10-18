<?php

namespace App\Policies;

use App\Models\RecipeQuestion;
use App\Models\RecipeQuestionReport;
use App\Models\RecipeQuestionVote;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class RecipeQuestionPolicy
{
    use HandlesAuthorization;

    /**
     * Determine if the given question can be delete by the user.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\RecipeQuestion  $question
     * @return bool
     */
    public function delete(User $user, RecipeQuestion $question)
    {
        return $user->id === $question->user_id;
    }

    /**
     * Determine if the given question can be edited by the user.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\RecipeQuestion  $question
     * @return bool
     */
    public function edit(User $user, RecipeQuestion $question)
    {
        return $user->id === $question->user_id;
    }

    /**
     * Determine if the given question can be reported by the user.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\RecipeQuestion  $question
     * @return bool
     */
    public function report(User $user, RecipeQuestion $question)
    {
        return ($user->id !== $question->user_id
            && !RecipeQuestionReport::reported($user->id, $question->id)->count());
    }

    /**
     * Determine if the given question can be voted by the user.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\RecipeQuestion  $question
     * @return bool
     */
    public function vote(User $user, RecipeQuestion $question)
    {
        return ($user->id !== $question->user_id
            && !RecipeQuestionVote::voted($user->id, $question->id)->count());
    }
}
