<?php

namespace App\Events\RecipeQuestion;

use App\Models\RecipeQuestion;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class RecipeQuestionViewed
{
    use InteractsWithSockets, SerializesModels;

    /**
     * @var \App\Models\RecipeQuestion $question
     */
    public $question;

    /**
     * RecipeQuestionViewed constructor.
     * @param RecipeQuestion $question
     */
    public function __construct(RecipeQuestion $question)
    {
        $this->question = $question;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }
}
