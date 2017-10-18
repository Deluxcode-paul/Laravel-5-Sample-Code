<?php

namespace App\Policies;

use App\Models\ReviewVote;
use App\Models\User;
use App\Models\Review;
use App\Models\ReviewReport;
use Illuminate\Auth\Access\HandlesAuthorization;

class ReviewPolicy
{
    use HandlesAuthorization;

    /**
     * Determine if the given review can be deleted by the user.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Review  $review
     * @return bool
     */
    public function delete(User $user, Review $review)
    {
        return $user->id === $review->user_id;
    }

    /**
     * Determine if the given review can be edited by the user.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Review  $review
     * @return bool
     */
    public function edit(User $user, Review $review)
    {
        return $user->id === $review->user_id;
    }

    /**
     * Determine if the given review can be reported by the user.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Review  $review
     * @return bool
     */
    public function report(User $user, Review $review)
    {
        return ($user->id !== $review->user_id
            && !ReviewReport::reported($user->id, $review->id)->count());
    }

    /**
     * Determine if the given review can be voted by the user.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Review  $review
     * @return bool
     */
    public function vote(User $user, Review $review)
    {
        return ($user->id !== $review->user_id
            && !ReviewVote::voted($user->id, $review->id)->count());
    }
}
