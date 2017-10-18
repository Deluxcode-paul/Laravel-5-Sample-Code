<?php

namespace App\Listeners\Forms;

use Bfm\Forms\Events\FormSubmitted;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Mail;
use App\Mail\SendContactForm;
use App\Enums\UserRole;
use App\Models\User;

class SendAdminFormEmail
{
    /**
     * Handle the event.
     *
     * @param  FormSubmitted  $event
     * @return void
     */
    public function handle(FormSubmitted $event)
    {
        $admins = User::whereHas('roles', function ($query) {
            $query->where('id', UserRole::ROLE_ADMIN);
        })->get();

        switch ($event->submit->form->slug) {
            case 'contact_us':
            default:
                foreach ($admins as $admin) {
                    Mail::to($admin->email)->send(new SendContactForm($event->submit));
                }
                break;
        }
    }
}
