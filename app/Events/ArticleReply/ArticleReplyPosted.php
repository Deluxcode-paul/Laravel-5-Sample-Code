<?php

namespace App\Events\ArticleReply;

use App\Models\ArticleReply;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class ArticleReplyPosted
{
    use InteractsWithSockets, SerializesModels;

    /**
     * @var \App\Models\ArticleReply $reply
     */
    public $reply;

    /**
     * ArticleReplyPosted constructor.
     * @param ArticleReply $reply
     */
    public function __construct(ArticleReply $reply)
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
