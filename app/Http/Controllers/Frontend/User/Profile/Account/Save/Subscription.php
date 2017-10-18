<?php

namespace App\Http\Controllers\Frontend\User\Profile\Account\Save;

use App\Http\Controllers\Frontend\User\Profile\AbstractProfile;
use App\Http\Requests\Frontend\User\Profile\Account\SaveSubscriptionRequest;

/**
 * Class Subscription
 * @package App\Http\Controllers\Frontend\User\Profile\Account\Save
 */
class Subscription extends AbstractProfile
{
    /**
     * @param SaveSubscriptionRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function __invoke(SaveSubscriptionRequest $request)
    {
        $this->currentUser->is_subscribed = ($request->get('is_subscribed') != null) ? true : false;
        $status = ($request->get('is_subscribed') != null) ?
            trans('user/profile.ajax_messages.subscribed')
            : trans('user/profile.ajax_messages.unsubscribed');

        $this->currentUser->save();

        return response()->json(compact('status'));
    }
}
