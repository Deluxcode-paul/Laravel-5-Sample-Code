<?php

namespace App\Mail;

use App\Models\CommunityNotificationReply;
use App\Models\CommunityNotificationTag;
use App\Models\CommunityNotificationUpdate;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class CommunityNotification extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * @var
     */
    protected $tags;

    /**
     * @var
     */
    protected $replies;

    /**
     * @var
     */
    protected $updates;

    /**
     * CommunityNotification constructor.
     * @param $tags
     * @param $replies
     * @param $updates
     */
    public function __construct($tags, $replies, $updates)
    {
        $this->tags    = $tags;
        $this->replies = $replies;
        $this->updates = $updates;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject(trans('community.notification_subject').date('Y-m-d'))
            ->from(config('mail.from.address'), config('mail.from.name'))
            ->view('community.mail.notification')
            ->with([
                'tags'    => $this->tags,
                'replies' => $this->replies,
                'updates' => $this->updates
            ]);
    }
}
