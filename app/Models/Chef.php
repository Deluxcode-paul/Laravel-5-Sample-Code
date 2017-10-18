<?php

namespace App\Models;

use App\Enums\UserRole;
use Illuminate\Database\Eloquent\Builder;

/**
 * Class Chef
 * @package App\Models
 */
class Chef extends User
{
    /**
     * @return void
     */
    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope('chef', function (Builder $builder) {
            $builder->join('role_users', 'users.id', '=', 'role_users.user_id')
                ->where(function ($query) {
                    $query->where('role_users.role_id', UserRole::ROLE_COMMUNITY_CHEF)
                        ->orWhere('role_users.role_id', UserRole::ROLE_PROFESSIONAL_CHEF);
                });
        });
    }
}
