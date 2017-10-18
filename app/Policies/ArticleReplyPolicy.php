<?php

namespace App\Policies;

use App\Models\ArticleReply;
use App\Models\ArticleReplyReport;
use App\Models\ArticleReplyVote;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ArticleReplyPolicy
{
    use HandlesAuthorization;

    /**
     * Determine if the given article reply can be deleted by the user.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\ArticleReply  $reply
     * @return bool
     */
    public function delete(User $user, ArticleReply $reply)
    {
        return $user->id === $reply->user_id;
    }

    /**
     * Determine if the given article reply can be edited by the user.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\ArticleReply  $reply
     * @return bool
     */
    public function edit(User $user, ArticleReply $reply)
    {
        return $user->id === $reply->user_id;
    }

    /**
     * Determine if the given recipe answer can be reported by the user.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\ArticleReply  $reply
     * @return bool
     */
    public function report(User $user, ArticleReply $reply)
    {
        return ($user->id !== $reply->user_id
            && !ArticleReplyReport::reported($user->id, $reply->id)->count());
    }

    /**
     * Determine if the given recipe answer can be voted by the user.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\ArticleReply  $reply
     * @return bool
     */
    public function vote(User $user, ArticleReply $reply)
    {
        return ($user->id !== $reply->user_id
            && !ArticleReplyVote::voted($user->id, $reply->id)->count());
    }
}
