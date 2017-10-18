<?php

namespace App\Notifications;

use App\Models\Submission;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

/**
 * Class NewSubmission
 * @package App\Notifications
 */
class NewSubmission extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * @var Submission|mixed
     */
    protected $submission;

    /**
     * Create a new notification instance.
     *
     * @param  mixed  $submission
     */
    public function __construct(Submission $submission)
    {
        $this->submission = $submission;
    }

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
            ->subject('New Submission')
            ->line('Hi '.$notifiable->fullName.',')
            ->line("There is a new Contact Us form submission.")
            ->action('Check it now', $this->submission->getAdminUrl());
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
