<?php

namespace App\Policies;

use App\Models\GeneralQuestion;
use App\Models\GeneralQuestionReport;
use App\Models\GeneralQuestionVote;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class GeneralQuestionPolicy
{
    use HandlesAuthorization;

    /**
     * Determine if the given question can be deleted by the user.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\GeneralQuestion  $question
     * @return bool
     */
    public function delete(User $user, GeneralQuestion $question)
    {
        return $user->id === $question->user_id;
    }

    /**
     * Determine if the given question can be edited by the user.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\GeneralQuestion  $question
     * @return bool
     */
    public function edit(User $user, GeneralQuestion $question)
    {
        return $user->id === $question->user_id;
    }

    /**
     * Determine if the given question can be reported by the user.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\GeneralQuestion  $question
     * @return bool
     */
    public function report(User $user, GeneralQuestion $question)
    {
        return ($user->id !== $question->user_id
            && !GeneralQuestionReport::reported($user->id, $question->id)->count());
    }

    /**
     * Determine if the given question can be voted by the user.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\GeneralQuestion  $question
     * @return bool
     */
    public function vote(User $user, GeneralQuestion $question)
    {
        return ($user->id !== $question->user_id
            && !GeneralQuestionVote::voted($user->id, $question->id)->count());
    }
}
