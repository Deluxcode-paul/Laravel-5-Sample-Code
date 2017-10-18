<?php

namespace App\Listeners\Recipe;

use App\Events\Recipe\RecipeShared;
use App\Models\RecipeShares;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class UpdateRecipeShares
{
    /**
     * Handle the event.
     *
     * @param  RecipeShared  $event
     * @return void
     */
    public function handle(RecipeShared $event)
    {
        $shares = $event->recipe->shares;

        if ($shares) {
            $shares->increment('shares');
        } else {
            $shares = new RecipeShares();
            $shares->shares = 1;
            $event->recipe->shares()->save($shares);
        }
    }
}
