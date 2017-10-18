<?php

namespace App\Http\Controllers\Frontend\User\Profile\Account;

use App\Http\Controllers\Frontend\User\Profile\AbstractProfile;
use App\Models\Allergen;
use App\Models\Diet;
use App\Models\Country;
use App\Models\State;
use Assets;

/**
 * Class View
 * @package App\Http\Controllers\Frontend\User\Profile\Account
 */
class View extends AbstractProfile
{
    public function __invoke()
    {
        $allergens = Allergen::all();
        $diets = Diet::all();
        $isChef = $this->currentUser->isChef();

        if ($isChef) {
            $states = State::pluck('title', 'id');
            $countries = Country::pluck('title', 'id');
        } else {
            $states = [];
            $countries = [];
        }

        Assets::group('frontend')->addJs('user/profile/account.js');

        return view('user.profile.account', compact(
            'allergens',
            'diets',
            'states',
            'countries',
            'isChef'
        ));
    }
}
