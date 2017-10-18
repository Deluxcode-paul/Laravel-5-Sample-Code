<?php

namespace App\Policies;

use App\Models\ArticleComment;
use App\Models\ArticleCommentReport;
use App\Models\ArticleCommentVote;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ArticleCommentPolicy
{
    use HandlesAuthorization;

    /**
     * Determine if the given comment can be deleted by the user.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\ArticleComment  $comment
     * @return bool
     */
    public function delete(User $user, ArticleComment $comment)
    {
        return $user->id === $comment->user_id;
    }

    /**
     * Determine if the given comment can be edited by the user.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\ArticleComment  $comment
     * @return bool
     */
    public function edit(User $user, ArticleComment $comment)
    {
        return $user->id === $comment->user_id;
    }

    /**
     * Determine if the given comment can be reported by the user.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\ArticleComment  $comment
     * @return bool
     */
    public function report(User $user, ArticleComment $comment)
    {
        return ($user->id !== $comment->user_id
            && !ArticleCommentReport::reported($user->id, $comment->id)->count());
    }

    /**
     * Determine if the given comment can be voted by the user.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\ArticleComment  $comment
     * @return bool
     */
    public function vote(User $user, ArticleComment $comment)
    {
        return ($user->id !== $comment->user_id
            && !ArticleCommentVote::voted($user->id, $comment->id)->count());
    }
}
