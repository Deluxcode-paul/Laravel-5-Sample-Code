<?php

namespace App\Policies;

use App\Models\ReviewComment;
use App\Models\ReviewCommentReport;
use App\Models\ReviewCommentVote;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ReviewCommentPolicy
{
    use HandlesAuthorization;

    /**
     * Determine if the given review comment can be deleted by the user.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\ReviewComment  $comment
     * @return bool
     */
    public function delete(User $user, ReviewComment $comment)
    {
        return $user->id === $comment->user_id;
    }
    /**
     * Determine if the given review comment can be edited by the user.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\ReviewComment  $comment
     * @return bool
     */
    public function edit(User $user, ReviewComment $comment)
    {
        return $user->id === $comment->user_id;
    }

    /**
     * Determine if the given review comment can be reported by the user.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\ReviewComment  $comment
     * @return bool
     */
    public function report(User $user, ReviewComment $comment)
    {
        return ($user->id !== $comment->user_id
            && !ReviewCommentReport::reported($user->id, $comment->id)->count());
    }

    /**
     * Determine if the given review comment can be voted by the user.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\ReviewComment  $comment
     * @return bool
     */
    public function vote(User $user, ReviewComment $comment)
    {
        return ($user->id !== $comment->user_id
            && !ReviewCommentVote::voted($user->id, $comment->id)->count());
    }
}
