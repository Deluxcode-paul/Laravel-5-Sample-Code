<?php

namespace App\Listeners\RecipeReview;

use App\Events\RecipeReview\RecipeReviewViewed;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class UpdateRecipeReviewViews
{
    /**
     * Handle the event.
     *
     * @param  RecipeReviewViewed  $event
     * @return void
     */
    public function handle(RecipeReviewViewed $event)
    {
        $event->review->increment('views');
    }
}
