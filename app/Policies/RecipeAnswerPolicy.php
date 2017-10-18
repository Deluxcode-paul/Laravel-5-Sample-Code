<?php

namespace App\Policies;

use App\Models\RecipeAnswer;
use App\Models\RecipeAnswerReport;
use App\Models\RecipeAnswerVote;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class RecipeAnswerPolicy
{
    use HandlesAuthorization;

    /**
     * Determine if the given recipe answer can be deleted by the user.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\RecipeAnswer  $answer
     * @return bool
     */
    public function delete(User $user, RecipeAnswer $answer)
    {
        return $user->id === $answer->user_id;
    }

    /**
     * Determine if the given recipe answer can be edited by the user.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\RecipeAnswer  $answer
     * @return bool
     */
    public function edit(User $user, RecipeAnswer $answer)
    {
        return $user->id === $answer->user_id;
    }

    /**
     * Determine if the given recipe answer can be reported by the user.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\RecipeAnswer  $answer
     * @return bool
     */
    public function report(User $user, RecipeAnswer $answer)
    {
        return ($user->id !== $answer->user_id
            && !RecipeAnswerReport::reported($user->id, $answer->id)->count());
    }

    /**
     * Determine if the given recipe answer can be voted by the user.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\RecipeAnswer  $answer
     * @return bool
     */
    public function vote(User $user, RecipeAnswer $answer)
    {
        return ($user->id !== $answer->user_id
            && !RecipeAnswerVote::voted($user->id, $answer->id)->count());
    }
}
