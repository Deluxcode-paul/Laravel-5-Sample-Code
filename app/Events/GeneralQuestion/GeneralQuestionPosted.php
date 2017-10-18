<?php

namespace App\Events\GeneralQuestion;

use App\Models\GeneralQuestion;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class GeneralQuestionPosted
{
    use InteractsWithSockets, SerializesModels;

    /**
     * @var \App\Models\GeneralQuestion $question
     */
    public $question;

    /**
     * GeneralQuestionPosted constructor.
     * @param GeneralQuestion $question
     */
    public function __construct(GeneralQuestion $question)
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
