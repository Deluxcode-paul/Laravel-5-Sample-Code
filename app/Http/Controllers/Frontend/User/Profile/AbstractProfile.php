<?php

namespace App\Http\Controllers\Frontend\User\Profile;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Assets;

abstract class AbstractProfile extends Controller
{
    /**
     * @var User user
     */
    protected $currentUser;

    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            $this->currentUser = Auth::user();
            return $next($request);
        });
    }
}
