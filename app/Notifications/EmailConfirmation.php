<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

/**
 * Class EmailConfirmation
 * @package App\Notifications
 */
class EmailConfirmation extends Notification
{
    use Queueable;

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->view('notifications.email')
                    ->from(config('mail.from.address'), config('mail.from.name'))
                    ->subject('Verify your email address')
                    ->line('Hi '.$notifiable->fullName.',')
                    ->line('To finish setting up this account, we just need to make sure this email address is yours.')
                    ->action(
                        'Verify your kosher.com account',
                        route('email_confirmation', $notifiable->confirmation_code).
                        '?email='.urlencode($notifiable->email)
                    );
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
