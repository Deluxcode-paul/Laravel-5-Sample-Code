<?php

namespace App\Http\Controllers\Frontend\User\Auth;

use App\Enums\UserRole;
use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after login / registration.
     *
     * @var string
     */
    protected $redirectTo = '/user/profile/account/';

    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Show the application registration form.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function showRegistrationForm(Request $request)
    {
        $destination = $request->input('destination');
        $loginUrl = route('login');
        if (!empty($destination)) {
            $loginUrl .= '?destination=' . urlencode($destination);
        }

        return view('auth.register', compact('loginUrl'));
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|min:2|max:255|unique:users,name',
            'first_name' => 'required|min:2|max:255',
            'last_name' => 'min:2|max:255',
            'email' => 'required|email|max:255|unique:users,email',
            'password' => 'required|min:8|max:255',
            'terms' => 'required'
        ], [
            'name.required' => 'The username field is required.',
            'name.unique' => 'User with this username already exists.',
            'name.min' => 'The username must be at least 2 characters.',
            'name.max' => 'The username may not be greater than 255 characters.',
            'email.unique' => 'User with this email already exists. Please use Forgot your password.',
            'terms.required' => 'Please accept Terms and Conditions.'
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    protected function create(array $data)
    {
        $user = User::create([
            'name' => $data['name'],
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'confirmation_code' => str_random(40)
        ]);

        $user->assignRole(UserRole::label(UserRole::ROLE_USER));
        $user->sendEmailConfirmationNotification();

        return $user;
    }

    /**
     * The user has been registered.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  mixed  $user
     * @return mixed
     */
    protected function registered(Request $request, $user)
    {
        $request->session()->flash('js-flash-message', trans('auth.verify_email_message'));

        $destination = $request->input('destination');
        if ($destination) {
            return redirect()->to($destination);
        }

        return redirect($this->redirectPath());
    }
}
