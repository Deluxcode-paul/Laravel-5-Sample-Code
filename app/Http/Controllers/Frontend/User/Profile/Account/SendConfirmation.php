<?php

namespace App\Http\Controllers\Frontend\User\Profile\Account;

use App\Http\Controllers\Frontend\User\Profile\AbstractProfile;

/**
 * Class SendConfirmation
 * @package App\Http\Controllers\Frontend\User\Profile\Account
 */
class SendConfirmation extends AbstractProfile
{
    /**
     * @return \Illuminate\Http\RedirectResponse
     */
    public function __invoke()
    {
        $this->currentUser->sendEmailConfirmationNotification();

        return response()->json(['message' => trans('auth.verify_email_message')]);
    }
}
