<?php

namespace App\Http\Controllers\Frontend\User\Profile\Account\Save;

use App\Http\Controllers\Frontend\User\Profile\AbstractProfile;
use Validator;
use Illuminate\Http\Request;
use View;
use App\Models\Allergen;
use App\Models\Diet;

class Preferences extends AbstractProfile
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
            $allergens = Allergen::all();
            $diets     = Diet::all();

            View::share('errors', $validator->messages());

            $this->request->flash();

            $data['error']   = true;
            $data['content'] = view('user.profile.account.preferences_edit', compact(
                'allergens',
                'diets'
            ))->render();
        } else {
            $this->save();
            $data['error']   = false;
            $data['content'] = view('user.profile.account.preferences_view')->render();
        }

        return response()->json($data);
    }

    /**
     * Save
     */
    protected function save()
    {
        $allergens = is_array($this->request->allergens) ? $this->request->allergens : [];
        $diets = is_array($this->request->diets) ? $this->request->diets : [];

        $this->currentUser->allergens()->sync($allergens);
        $this->currentUser->diets()->sync($diets);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'allergens'   => 'array',
            'diets'       => 'array',
            'allergens.*' => 'integer',
            'diets.*'     => 'integer',
        ];
    }
}
