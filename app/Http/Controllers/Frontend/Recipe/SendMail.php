<?php

namespace App\Http\Controllers\Frontend\Recipe;

use App\Http\Controllers\Controller;
use App\Http\Requests\Frontend\RecipeEmailRequest;
use Illuminate\Support\Facades\Mail;
use App\Models\Recipe;
use App\Mail\SendRecipe;

/**
 * Class SendMail
 * @package App\Http\Controllers\Frontend\Share\MailTo
 */
class SendMail extends Controller
{
    public function __invoke(RecipeEmailRequest $request, Recipe $recipe)
    {
        Mail::to($request->get('email'))->send(new SendRecipe($recipe));

        return response()->json(['message' => trans('share.mail_to_already_sent'), 'type'=>'success']);
    }
}
