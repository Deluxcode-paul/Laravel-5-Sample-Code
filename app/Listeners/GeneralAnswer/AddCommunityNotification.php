<?php

namespace App\Listeners\GeneralAnswer;

use App\Enums\CommunityModel;
use App\Events\GeneralAnswer\GeneralAnswerPosted;
use App\Models\CommunityNotificationReply;
use App\Models\CommunityNotificationUpdate;
use App\Models\GeneralAnswer;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class AddCommunityNotification
{
    /**
     * @var
     */
    protected $event;

    /**
     * Handle the event.
     *
     * @param  GeneralAnswerPosted  $event
     * @return void
     */
    public function handle(GeneralAnswerPosted $event)
    {
        $this->event = $event;

        $this->createReplyNotification();
        $this->createUpdateNotification();
    }

    /**
     * Create Reply notification
     */
    protected function createReplyNotification()
    {
        $notification             = new CommunityNotificationReply();
        $notification->user_id    = $this->event->reply->question->user_id;
        $notification->reply_id   = $this->event->reply->id;
        $notification->reply_type = CommunityModel::GENERAL_ANSWER;
        $notification->save();
    }

    /**
     * Create Update Notification
     */
    protected function createUpdateNotification()
    {

        $users = GeneralAnswer::select('user_id')
            ->where('question_id', $this->event->reply->question->id)
            ->where('user_id', '<>', $this->event->reply->user_id)
            ->distinct()
            ->pluck('user_id');

        foreach ($users as $user_id) {
            $notification             = new CommunityNotificationUpdate();
            $notification->user_id    = $user_id;
            $notification->reply_id   = $this->event->reply->id;
            $notification->reply_type = CommunityModel::GENERAL_ANSWER;
            $notification->save();
        }
    }
}
