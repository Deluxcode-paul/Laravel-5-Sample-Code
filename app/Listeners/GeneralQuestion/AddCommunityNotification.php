<?php

namespace App\Listeners\GeneralQuestion;

use App\Enums\CommunityModel;
use App\Events\GeneralQuestion\GeneralQuestionPosted;
use App\Models\CommunityNotificationTag;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class AddCommunityNotification
{
    /**
     * Handle the event.
     *
     * @param  GeneralQuestionPosted  $event
     * @return void
     */
    public function handle(GeneralQuestionPosted $event)
    {
        foreach ($event->question->chefs as $chef) {
            $notification            = new CommunityNotificationTag();
            $notification->user_id   = $chef->id;
            $notification->post_id   = $event->question->id;
            $notification->post_type = CommunityModel::GENERAL_QUESTION;
            $notification->save();
        }
    }
}
