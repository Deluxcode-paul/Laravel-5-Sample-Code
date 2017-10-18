<?php

namespace App\Http\Controllers\Frontend\Pages;

use App\Enums\ContactInquiryTypes;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/**
 * Class Contact
 * @package App\Http\Controllers\Frontend\Pages
 */
class Contact extends Controller
{
    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function __invoke(Request $request)
    {
        $values = [];

        if (Auth::check()) {
            $user = Auth::user();
            $values['email'] = $user->email;
            $values['name'] = $user->fullName;
        }

        $values['inquiry_type'] = $request->input('inquiry_type', '');

        return view('pages.contact', [
            'inquiryTypes' => ContactInquiryTypes::labels(),
            'values' => $values
        ]);
    }
}
