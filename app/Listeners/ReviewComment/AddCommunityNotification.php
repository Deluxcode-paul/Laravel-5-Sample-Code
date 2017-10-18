<?php

namespace App\Listeners\ReviewComment;

use App\Enums\CommunityModel;
use App\Events\ReviewComment\ReviewCommentPosted;
use App\Models\CommunityNotificationReply;
use App\Models\CommunityNotificationUpdate;
use App\Models\ReviewComment;
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
     * @param  ReviewCommentPosted  $event
     * @return void
     */
    public function handle(ReviewCommentPosted $event)
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
        $notification->user_id    = $this->event->reply->review->user_id;
        $notification->reply_id   = $this->event->reply->id;
        $notification->reply_type = CommunityModel::REVIEW_COMMENT;
        $notification->save();
    }

    /**
     * Create Update Notification
     */
    protected function createUpdateNotification()
    {

        $users = ReviewComment::select('user_id')
            ->where('review_id', $this->event->reply->review->id)
            ->where('user_id', '<>', $this->event->reply->user_id)
            ->distinct()
            ->pluck('user_id');

        foreach ($users as $user_id) {
            $notification             = new CommunityNotificationUpdate();
            $notification->user_id    = $user_id;
            $notification->reply_id   = $this->event->reply->id;
            $notification->reply_type = CommunityModel::REVIEW_COMMENT;
            $notification->save();
        }
    }
}
