<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

/**
 * Class ShoppingList
 * @package App\Mail
 */
class ShoppingList extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * ShoppingList instance
     *
     * @var Shopping List
     */
    protected $shoppingList;

    /**
     * Create a new message instance.
     */
    public function __construct($shoppingList)
    {
        $this->shoppingList = $shoppingList;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject(trans('user/profile.email.shopping_list_subject'))
            ->from(config('mail.from.address'), config('mail.from.name'))
            ->view('user.profile.shopping_lists.mail')
            ->with([
                'shoppingList' => $this->shoppingList
            ]);
    }
}
