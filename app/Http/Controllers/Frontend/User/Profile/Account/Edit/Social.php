<?php

namespace App\Http\Controllers\Frontend\User\Profile\Account\Edit;

use App\Http\Controllers\Frontend\User\Profile\AbstractProfile;
use Illuminate\Http\Request;

/**
 * Class Social
 * @package App\Http\Controllers\Frontend\User\Profile\Account\Edit
 */
class Social extends AbstractProfile
{
    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function __invoke(Request $request)
    {
        $data = [];

        $request->flush();

        $data['content'] = view('user.profile.account.social_edit')->render();

        return response()->json($data);
    }
}
