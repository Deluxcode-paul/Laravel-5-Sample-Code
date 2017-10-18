<?php

namespace App\Events\GeneralAnswer;

use App\Models\GeneralAnswer;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class GeneralAnswerPosted
{
    use InteractsWithSockets, SerializesModels;

    /**
     * @var \App\Models\GeneralAnswer $reply
     */
    public $reply;

    /**
     * GeneralAnswerPosted constructor.
     * @param GeneralAnswer $reply
     */
    public function __construct(GeneralAnswer $reply)
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
