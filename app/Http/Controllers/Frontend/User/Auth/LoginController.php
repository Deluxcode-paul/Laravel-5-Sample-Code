<?php

namespace App\Http\Controllers\Frontend\User\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login / registration.
     *
     * @var string
     */
    protected $redirectTo = '/user/profile/account/';

    /**
     * Create a new controller instance.
     *
     */
    public function __construct()
    {
        $this->middleware('guest', ['except' => 'logout']);
    }

    /**
     * Show the application's login form.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function showLoginForm(Request $request)
    {
        $destination = $request->input('destination');
        $registerUrl = route('register');
        if (!empty($destination)) {
            $registerUrl .= '?destination=' . urlencode($destination);
        }

        return view('auth.login', compact('registerUrl'));
    }

    /**
     * Handle a login request to the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function login(Request $request)
    {
        $this->validateLogin($request);

        if ($this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);

            return $this->sendLockoutResponse($request);
        }

        if ($this->checkDeleted($request)) {
            return $this->sendDeletedLoginResponse($request);
        }

        $credentials = $this->credentials($request);
        $secondaryCredentials = $this->secondaryCredentials($request);

        if ($this->guard()->attempt($credentials, $request->has('remember'))) {
            if ($request->has('destination')) {
                return $this->redirectToDestination($request);
            } else {
                return $this->sendLoginResponse($request);
            }
        } elseif ($this->guard()->attempt($secondaryCredentials, $request->has('remember'))) {
            if ($request->has('destination')) {
                return $this->redirectToDestination($request);
            } else {
                return $this->sendLoginResponse($request);
            }
        }

        $this->incrementLoginAttempts($request);

        return $this->sendFailedLoginResponse($request);
    }

    /**
     * Checks if user was soft deleted
     * @param Request $request
     * @return bool
     */
    protected function checkDeleted(Request $request)
    {
        $result = false;

        $user = User::where($this->username(), '=', $request->email)
            ->withTrashed()->first();
        if ($user) {
            if (Hash::check($request->password, $user->password)) {
                $result = ($user->deleted_at != null) ? true :false;
            }
        }
        return $result;
    }

    /**
     * Get the deleted login response instance.
     *
     * @param \Illuminate\Http\Request  $request
     * @return mixed
     */
    protected function sendDeletedLoginResponse(Request $request)
    {
        return redirect()->back()
            ->withInput($request->only($this->username(), 'remember'))
            ->withErrors([
                $this->username() => trans('auth.deleted'),
            ]);
    }

    /**
     * @param Request $request
     * @return array
     */
    protected function secondaryCredentials(Request $request)
    {
        return [
            'name' => $request->get('email'),
            'password' => $request->get('password')
        ];
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    private function redirectToDestination($request)
    {
        $request->session()->regenerate();
        $this->clearLoginAttempts($request);
        $destination = $request->input('destination');

        return redirect()->to($destination);
    }
}
