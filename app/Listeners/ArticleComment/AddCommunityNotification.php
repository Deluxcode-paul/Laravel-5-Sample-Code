<?php

namespace App\Listeners\ArticleComment;

use App\Enums\CommunityModel;
use App\Events\ArticleComment\ArticleCommentPosted;
use App\Models\CommunityNotificationTag;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class AddCommunityNotification
{
    /**
     * Handle the event.
     *
     * @param  ArticleCommentPosted  $event
     * @return void
     */
    public function handle(ArticleCommentPosted $event)
    {
        foreach ($event->comment->chefs as $chef) {
            $notification            = new CommunityNotificationTag();
            $notification->user_id   = $chef->id;
            $notification->post_id   = $event->comment->id;
            $notification->post_type = CommunityModel::ARTICLE_COMMENT;
            $notification->save();
        }
    }
}
