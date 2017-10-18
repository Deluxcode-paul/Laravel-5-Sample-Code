<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use Bfm\Forms\Models\Submit;

class SendContactForm extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * @var \Bfm\Forms\Models\Submit $submit
     */
    protected $submit;

    /**
     * SendContactForm constructor.
     * @param Submit $submit
     */
    public function __construct(Submit $submit)
    {
        $this->submit = $submit;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Contact form submitted')
            ->from(config('mail.from.address'), config('mail.from.name'))
            ->view('pages.contact.email')
            ->with([
                'values' => $this->submit->getValues()
            ]);
    }
}
