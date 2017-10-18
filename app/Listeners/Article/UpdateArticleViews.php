<?php

namespace App\Listeners\Article;

use App\Events\Article\ArticleViewed;
use App\Models\ArticleViews;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class UpdateArticleViews
{
    /**
     * Handle the event.
     *
     * @param  ArticleViewed  $event
     * @return void
     */
    public function handle(ArticleViewed $event)
    {
        $views = $event->article->views;

        if ($views) {
            $views->increment('views');
        } else {
            $views = new ArticleViews();
            $views->views = 1;
            $event->article->views()->save($views);
        }
    }
}
