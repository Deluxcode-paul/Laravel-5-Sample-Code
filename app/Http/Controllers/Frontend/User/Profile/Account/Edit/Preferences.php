<?php

namespace App\Http\Controllers\Frontend\User\Profile\Account\Edit;

use App\Http\Controllers\Frontend\User\Profile\AbstractProfile;
use App\Models\Allergen;
use App\Models\Diet;
use Illuminate\Http\Request;

class Preferences extends AbstractProfile
{
    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function __invoke(Request $request)
    {
        $data = [];

        $allergens = Allergen::all();
        $diets     = Diet::all();

        $request->flush();

        $data['content'] = view('user.profile.account.preferences_edit', compact(
            'allergens',
            'diets'
        ))->render();

        return response()->json($data);
    }
}
