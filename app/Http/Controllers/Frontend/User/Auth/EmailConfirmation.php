<?php

namespace App\Http\Controllers\Frontend\User\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

/**
 * Class EmailConfirmation
 * @package App\Http\Controllers\Frontend\User\Auth
 */
class EmailConfirmation extends Controller
{
    /**
     * Where to redirect logged users
     *
     * @var string
     */
    protected $redirectLogged = '/user/profile/account/';

    /**
     * Where to redirect guest users
     *
     * @var string
     */
    protected $redirectGuest = '/login';

    /**
     * @param Request $request
     * @param $confirmation
     * @return \Illuminate\Http\RedirectResponse
     */
    public function __invoke(Request $request, $confirmation)
    {
        $message = $this->confirm($request, $confirmation)
            ? trans('auth.verify_email_success') : trans('auth.verify_email_fail');
        $request->session()->flash('js-flash-message', $message);

        return $this->redirect();
    }

    /**
     * @param Request $request
     * @param $confirmation
     * @return bool
     */
    protected function confirm(Request $request, $confirmation)
    {
        $result = false;

        if ($request->has('email')) {
            $user = User::where('email', '=', $request->get('email'))->first();
            if ($user) {
                if ($user->is_confirmed) {
                    $result = false;
                } else {
                    if ($user->confirmation_code == $confirmation) {
                        $user->is_confirmed = true;
                        if ($user->save()) {
                            $result = true;
                        }
                    } else {
                        $result = false;
                    }
                }
            }
        }

        return $result;
    }

    /**
     * @return \Illuminate\Http\RedirectResponse
     */
    protected function redirect()
    {
        $destination = Auth::check() ? $this->redirectLogged : $this->redirectGuest;

        return redirect()->to($destination);
    }
}
