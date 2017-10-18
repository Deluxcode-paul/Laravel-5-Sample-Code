<?php

namespace App\Events\ArticleComment;

use App\Models\ArticleComment;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class ArticleCommentViewed
{
    use InteractsWithSockets, SerializesModels;

    /**
     * @var \App\Models\ArticleComment $comment
     */
    public $comment;

    /**
     * ArticleCommentViewed constructor.
     * @param ArticleComment $comment
     */
    public function __construct(ArticleComment $comment)
    {
        $this->comment = $comment;
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
