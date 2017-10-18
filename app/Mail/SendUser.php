<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Models\User;

class SendUser extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * @var \App\Models\User $user
     */
    protected $user;

    /**
     * Article constructor.
     * @param \App\Models\User $user
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Chef Profile: '.$this->user->fullName)
            ->from(config('mail.from.address'), config('mail.from.name'))
            ->view('user.public_profile.share.email')
            ->with([
                'user' => $this->user
            ]);
    }
}
