<?php

namespace App\Policies;

use App\Models\GeneralAnswer;
use App\Models\GeneralAnswerReport;
use App\Models\GeneralAnswerVote;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class GeneralAnswerPolicy
{
    use HandlesAuthorization;

    /**
     * Determine if the given answer can be deleted by the user.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\GeneralAnswer  $answer
     * @return bool
     */
    public function delete(User $user, GeneralAnswer $answer)
    {
        return $user->id === $answer->user_id;
    }

    /**
     * Determine if the given answer can be edited by the user.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\GeneralAnswer  $answer
     * @return bool
     */
    public function edit(User $user, GeneralAnswer $answer)
    {
        return $user->id === $answer->user_id;
    }

    /**
     * Determine if the given answer can be reported by the user.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\GeneralAnswer  $answer
     * @return bool
     */
    public function report(User $user, GeneralAnswer $answer)
    {
        return ($user->id !== $answer->user_id
            && !GeneralAnswerReport::reported($user->id, $answer->id)->count());
    }

    /**
     * Determine if the given answer can be voted by the user.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\GeneralAnswer  $answer
     * @return bool
     */
    public function vote(User $user, GeneralAnswer $answer)
    {
        return ($user->id !== $answer->user_id
            && !GeneralAnswerVote::voted($user->id, $answer->id)->count());
    }
}
