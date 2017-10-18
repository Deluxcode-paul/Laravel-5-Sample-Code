<?php

namespace App\Http\Traits;

use App\Enums\UserRole;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Support\Facades\DB;

trait Community
{
    /**
     * @return \Illuminate\Support\Collection
     */
    protected function getTags()
    {
        return Tag::all()->pluck('title', 'id');
    }

    /**
     * @return mixed
     */
    protected function getChefs()
    {
        $fullName = DB::raw('CONCAT(users.first_name,\' \',users.last_name) as title');

        return User::whereHas('roles', function ($query) {
            $query->whereIn('id', [UserRole::ROLE_COMMUNITY_CHEF, UserRole::ROLE_PROFESSIONAL_CHEF]);
        })->select('users.id', $fullName)->pluck('title', 'id');
    }
}
