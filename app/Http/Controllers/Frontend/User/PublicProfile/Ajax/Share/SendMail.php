<?php

namespace App\Http\Controllers\Frontend\User\PublicProfile\Ajax\Share;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use App\Models\User;
use App\Http\Requests\Frontend\User\PublicProfile\UserEmailRequest;
use App\Mail\SendUser;

class SendMail extends Controller
{
    /**
     * @param UserEmailRequest $request
     * @param User $user
     * @return \Illuminate\Http\JsonResponse
     */
    public function __invoke(UserEmailRequest $request, User $user)
    {
        Mail::to($request->get('email'))->send(new SendUser($user));

        return response()->json(['message' => trans('share.mail_to_already_sent'), 'type'=>'success']);
    }
}
