<?php

namespace App\Events\ReviewComment;

use App\Models\ReviewComment;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class ReviewCommentPosted
{
    use InteractsWithSockets, SerializesModels;

    /**
     * @var \App\Models\ReviewComment $reply
     */
    public $reply;

    /**
     * ReviewCommentPosted constructor.
     * @param ReviewComment $reply
     */
    public function __construct(ReviewComment $reply)
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
