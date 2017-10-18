<?php

namespace App\Listeners\RecipeQuestion;

use App\Enums\CommunityModel;
use App\Events\RecipeQuestion\RecipeQuestionPosted;
use App\Models\CommunityNotificationTag;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class AddCommunityNotification
{
    /**
     * Handle the event.
     *
     * @param  RecipeQuestionPosted  $event
     * @return void
     */
    public function handle(RecipeQuestionPosted $event)
    {
        foreach ($event->question->chefs as $chef) {
            $notification            = new CommunityNotificationTag();
            $notification->user_id   = $chef->id;
            $notification->post_id   = $event->question->id;
            $notification->post_type = CommunityModel::RECIPE_QUESTION;
            $notification->save();
        }
    }
}
