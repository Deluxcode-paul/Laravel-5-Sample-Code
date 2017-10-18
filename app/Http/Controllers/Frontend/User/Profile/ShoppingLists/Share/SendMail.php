<?php

namespace App\Http\Controllers\Frontend\User\Profile\ShoppingLists\Share;

use App\Http\Controllers\Frontend\User\Profile\AbstractProfile;
use App\Http\Requests\Frontend\User\Profile\ShoppingLists\RecipeEmailRequest;
use Illuminate\Support\Facades\Mail;
use App\Mail\ShoppingList;

class SendMail extends AbstractProfile
{
    /**
     * @param RecipeEmailRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function __invoke(RecipeEmailRequest $request)
    {
        $shoppingList = $this->currentUser->getShoppingList($request->get('recipes'));

        Mail::to($request->get('email'))->send(new ShoppingList($shoppingList));

        return response()->json(['message' => trans('share.mail_to_already_sent'), 'type'=>'success']);
    }
}
