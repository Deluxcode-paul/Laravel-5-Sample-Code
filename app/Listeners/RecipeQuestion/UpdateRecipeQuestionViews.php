<?php

namespace App\Listeners\RecipeQuestion;

use App\Events\RecipeQuestion\RecipeQuestionViewed;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class UpdateRecipeQuestionViews
{
    /**
     * Handle the event.
     *
     * @param  RecipeQuestionViewed  $event
     * @return void
     */
    public function handle(RecipeQuestionViewed $event)
    {
        $event->question->increment('views');
    }
}
