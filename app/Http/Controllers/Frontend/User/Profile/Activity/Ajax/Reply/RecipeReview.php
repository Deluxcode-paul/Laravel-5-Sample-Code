<?php

namespace App\Http\Controllers\Frontend\User\Profile\Activity\Ajax\Reply;

use App\Events\ReviewComment\ReviewCommentPosted;
use App\Http\Controllers\Frontend\User\Profile\AbstractProfile;
use App\Http\Requests\Frontend\User\Profile\Activity\Reply\RecipeReviewRequest;
use App\Models\ReviewComment;
use App\Models\Review;

class RecipeReview extends AbstractProfile
{
    /**
     * @param RecipeReviewRequest $request
     * @param Review $review
     * @return \Illuminate\Http\JsonResponse
     */
    public function __invoke(RecipeReviewRequest $request, Review $review)
    {
        $item = new ReviewComment();
        $item->user_id = $this->currentUser->id;
        $item->review_id = $review->id;
        $item->fill($request->only([
            'details'
        ]));
        $item->save();

        event(new ReviewCommentPosted($item));

        $content = view('community.blocks.items.reply_ajax', compact('item'))->render();

        return response()->json(compact('content'));
    }
}
