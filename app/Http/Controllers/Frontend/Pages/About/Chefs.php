<?php

namespace App\Http\Controllers\Frontend\Pages\About;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Enums\UserRole;

class Chefs extends Controller
{
    /**
     * Controller main action
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function __invoke()
    {
        $chefs = $this->getChefs();

        return view('pages.about.chefs', compact('chefs'));
    }

    /**
     * Return list of chefs
     * @return mixed
     */
    protected function getChefs()
    {
        return User::whereHas('roles', function ($query) {
            $query->whereIn('id', [UserRole::ROLE_COMMUNITY_CHEF, UserRole::ROLE_PROFESSIONAL_CHEF]);
        })->get();
    }
}
