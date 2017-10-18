<?php

namespace App\Listeners\ArticleReply;

use App\Enums\CommunityModel;
use App\Events\ArticleReply\ArticleReplyPosted;
use App\Models\ArticleReply;
use App\Models\CommunityNotificationReply;
use App\Models\CommunityNotificationUpdate;
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
     * @param  ArticleReplyPosted  $event
     * @return void
     */
    public function handle(ArticleReplyPosted $event)
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
        $notification->user_id    = $this->event->reply->comment->user_id;
        $notification->reply_id   = $this->event->reply->id;
        $notification->reply_type = CommunityModel::ARTICLE_REPLY;
        $notification->save();
    }

    /**
     * Create Update Notification
     */
    protected function createUpdateNotification()
    {

        $users = ArticleReply::select('user_id')
            ->where('article_comment_id', $this->event->reply->comment->id)
            ->where('user_id', '<>', $this->event->reply->user_id)
            ->distinct()
            ->pluck('user_id');

        foreach ($users as $user_id) {
            $notification             = new CommunityNotificationUpdate();
            $notification->user_id    = $user_id;
            $notification->reply_id   = $this->event->reply->id;
            $notification->reply_type = CommunityModel::ARTICLE_REPLY;
            $notification->save();
        }
    }
}
