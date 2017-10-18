<?php

namespace App\Listeners\ArticleComment;

use App\Events\ArticleComment\ArticleCommentViewed;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class UpdateArticleCommentViews
{
    /**
     * Handle the event.
     *
     * @param  ArticleCommentViewed  $event
     * @return void
     */
    public function handle(ArticleCommentViewed $event)
    {
        $event->comment->increment('views');
    }
}
