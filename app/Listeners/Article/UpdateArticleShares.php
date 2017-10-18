<?php

namespace App\Listeners\Article;

use App\Events\Article\ArticleShared;
use App\Models\ArticleShares;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class UpdateArticleShares
{
    /**
     * Handle the event.
     *
     * @param  ArticleShared  $event
     * @return void
     */
    public function handle(ArticleShared $event)
    {
        $shares = $event->article->shares;

        if ($shares) {
            $shares->increment('shares');
        } else {
            $shares = new ArticleShares();
            $shares->shares = 1;
            $event->article->shares()->save($shares);
        }
    }
}
