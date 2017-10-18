<?php

namespace App\Http\Controllers\Frontend\Pages;

use App\Enums\UserRole;
use App\Http\Controllers\Controller;
use App\Http\Requests\Frontend\Pages\Contact\SubmissionRequest;
use App\Models\Submission;
use App\Models\User;
use App\Notifications\NewSubmission;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Session;

/**
 * Class ContactSubmit
 * @package App\Http\Controllers\Frontend\Pages
 */
class ContactSubmit extends Controller
{
    /**
     * @param SubmissionRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function __invoke(SubmissionRequest $request)
    {
        $userId = null;

        if (Auth::check()) {
            $userId = Auth::user()->id;
        }

        $submission = new Submission();
        $submission->user_id = $userId;
        $submission->ip_address = $request->ip();
        $submission->inquiry_type = $request->input('inquiry_type');
        $submission->name = $request->input('name');
        $submission->email = $request->input('email');
        $submission->message = $request->input('message');
        $submission->save();

        $admins = User::whereHas('roles', function ($query) {
            $query->where('role_id', UserRole::ROLE_ADMIN);
        })->get();
        Notification::send($admins, new NewSubmission($submission));

        Session::flash('msg', trans('pages/contact.form.thank_you'));

        return redirect()->route('contact');
    }
}
