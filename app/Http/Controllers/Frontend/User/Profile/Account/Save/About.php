<?php

namespace App\Http\Controllers\Frontend\User\Profile\Account\Save;

use App\Http\Controllers\Frontend\User\Profile\AbstractProfile;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\State;
use App\Models\Country;
use Illuminate\Support\Facades\View;

/**
 * Class About
 * @package App\Http\Controllers\Frontend\User\Profile\Account\Save
 */
class About extends AbstractProfile
{
    /**
     * @var Request
     */
    protected $request;
    /**
     * @var boolean
     */
    protected $isChef;

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function __invoke(Request $request)
    {
        $this->request = $request;
        $validator = Validator::make($this->request->all(), $this->rules());
        $data = [];
        $isChef = $this->currentUser->isChef();
        $this->isChef = $isChef;

        if ($validator->fails()) {
            View::share('errors', $validator->messages());
            $this->request->flash();

            if ($isChef) {
                $states = State::pluck('title', 'id');
                $countries = Country::pluck('title', 'id');
            } else {
                $states = [];
                $countries = [];
            }

            $data['error']   = true;
            $data['content'] = view('user.profile.account.about_edit', compact(
                'countries',
                'states',
                'isChef'
            ))->render();
        } else {
            $this->save();
            $data['error']   = false;
            $data['content'] = view('user.profile.account.about_view', compact(
                'isChef'
            ))->render();
        }

        return response()->json($data);
    }

    /**
     * Save
     */
    protected function save()
    {
        if ($this->isChef) {
            $fillOnly = [
                'first_name',
                'last_name',
                'bio',
                'city',
                'country_id',
                'state_id',
                'place_of_work',
                'status'
            ];
        } else {
            $fillOnly = [
                'first_name',
                'last_name'
            ];
        }

        $this->currentUser->fill($this->request->only($fillOnly));

        if (empty($this->request->input('state_id'))) {
            $this->currentUser->state_id = null;
        }

        if (empty($this->request->input('country_id'))) {
            $this->currentUser->country_id = null;
        }

        if ($this->request->input('password')) {
            $this->currentUser->password = Hash::make($this->request->input('password'));
        }

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
            'first_name' => 'required|max:255',
            'last_name' => 'max:255',
            'password' => 'confirmed|min:8|max:255',
            'bio' => 'string|max:1000',
            'city' => 'string|max:255',
            'country_id' => 'integer',
            'state_id' => 'integer',
            'place_of_work' => 'string|max:255',
            'status' => 'string|max:140'
        ];
    }
}
