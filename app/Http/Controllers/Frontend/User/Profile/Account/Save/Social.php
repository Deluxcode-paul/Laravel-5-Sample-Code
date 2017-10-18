<?php

namespace App\Http\Controllers\Frontend\User\Profile\Account\Save;

use App\Http\Controllers\Frontend\User\Profile\AbstractProfile;
use Validator;
use Illuminate\Http\Request;
use View;

class Social extends AbstractProfile
{
    /**
     * @var
     */
    protected $request;

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function __invoke(Request $request)
    {
        $this->request = $request;

        $validator = Validator::make($this->request->all(), $this->rules());

        $data = [];

        if ($validator->fails()) {
            View::share('errors', $validator->messages());

            $this->request->flash();

            $data['error']   = true;
            $data['content'] = view('user.profile.account.social_edit')->render();
        } else {
            $this->save();
            $data['error']   = false;
            $data['content'] = view('user.profile.account.social_view')->render();
        }

        return response()->json($data);
    }

    /**
     * Save
     */
    protected function save()
    {
        $this->currentUser->fill($this->request->only([
            'facebook',
            'instagram',
            'twitter',
            'youtube',
            'pinterest',
            'website'
        ]));

        $this->currentUser->save();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'facebook'  => 'max:255|url',
            'instagram' => 'max:255|url',
            'twitter'   => 'max:255|url',
            'youtube'   => 'max:255|url',
            'pinterest' => 'max:255|url',
            'website'   => 'max:255|url'
        ];
    }
}
