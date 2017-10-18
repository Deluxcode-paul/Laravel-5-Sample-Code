<?php

namespace App\Listeners\GeneralQuestion;

use App\Events\GeneralQuestion\GeneralQuestionViewed;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class UpdateGeneralQuestionViews
{
    /**
     * Handle the event.
     *
     * @param  GeneralQuestionViewed  $event
     * @return void
     */
    public function handle(GeneralQuestionViewed $event)
    {
        $event->question->increment('views');
    }
}
