<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Models\Video;

class SendVideo extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * @var \App\Models\Video $video
     */
    protected $video;

    /**
     * SendVideo constructor.
     * @param Video $video
     */
    public function __construct(Video $video)
    {
        $this->video = $video;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Video: '.$this->video->title)
            ->from(config('mail.from.address'), config('mail.from.name'))
            ->view('pages.watch.video.share.email')
            ->with([
                'video' => $this->video
            ]);
    }
}
