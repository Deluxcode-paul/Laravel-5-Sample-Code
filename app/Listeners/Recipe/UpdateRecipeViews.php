<?php

namespace App\Listeners\Recipe;

use App\Events\Recipe\RecipeViewed;
use App\Models\RecipeViews;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class UpdateRecipeViews
{
    /**
     * Handle the event.
     *
     * @param  RecipeViewed  $event
     * @return void
     */
    public function handle(RecipeViewed $event)
    {
        $views = $event->recipe->views;

        if ($views) {
            $views->increment('views');
        } else {
            $views = new RecipeViews();
            $views->views = 1;
            $event->recipe->views()->save($views);
        }
    }
}
