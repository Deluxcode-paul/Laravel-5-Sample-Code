<?php

namespace App\Listeners\RecipeReview;

use App\Enums\CommunityModel;
use App\Events\RecipeReview\RecipeReviewPosted;
use App\Models\CommunityNotificationTag;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class AddCommunityNotification
{
    /**
     * Handle the event.
     *
     * @param  RecipeReviewPosted  $event
     * @return void
     */
    public function handle(RecipeReviewPosted $event)
    {
        foreach ($event->review->chefs as $chef) {
            $notification            = new CommunityNotificationTag();
            $notification->user_id   = $chef->id;
            $notification->post_id   = $event->review->id;
            $notification->post_type = CommunityModel::RECIPE_REVIEW;
            $notification->save();
        }
    }
}
