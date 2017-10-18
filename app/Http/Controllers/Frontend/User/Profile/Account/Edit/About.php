<?php

namespace App\Http\Controllers\Frontend\User\Profile\Account\Edit;

use App\Http\Controllers\Frontend\User\Profile\AbstractProfile;
use App\Models\State;
use App\Models\Country;
use Illuminate\Http\Request;

/**
 * Class About
 * @package App\Http\Controllers\Frontend\User\Profile\Account\Edit
 */
class About extends AbstractProfile
{
    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function __invoke(Request $request)
    {
        $data = [];
        $request->flush();
        $data['isChef'] = $isChef = $this->currentUser->isChef();

        if ($isChef) {
            $states = State::pluck('title', 'id');
            $countries = Country::pluck('title', 'id');
        } else {
            $states = [];
            $countries = [];
        }

        $data['content'] = view('user.profile.account.about_edit', compact(
            'countries',
            'states',
            'isChef'
        ))->render();

        return response()->json($data);
    }
}
