<?php

namespace App\Events\RecipeAnswer;

use App\Models\RecipeAnswer;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class RecipeAnswerPosted
{
    use InteractsWithSockets, SerializesModels;

    /**
     * @var \App\Models\RecipeAnswer $reply
     */
    public $reply;

    /**
     * RecipeAnswerPosted constructor.
     * @param RecipeAnswer $reply
     */
    public function __construct(RecipeAnswer $reply)
    {
        $this->reply = $reply;
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
