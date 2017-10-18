<?php

namespace App\Models;

use App\Enums\UserRole;
use Illuminate\Database\Eloquent\Builder;

/**
 * Class TopChef
 * @package App\Models
 */
class TopChef extends User
{
    /**
     * @return void
     */
    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope('chef', function (Builder $builder) {
            $builder->join('role_users', 'users.id', '=', 'role_users.user_id')
                ->where('role_users.role_id', UserRole::ROLE_PROFESSIONAL_CHEF);
        });
    }

    /**
     * @return string
     */
    public function getUrl()
    {
        return $this->publicProfileUrl;
    }

    /**
     * A user may have multiple roles.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function roles()
    {
        return $this->belongsToMany(
            config('laravel-permission.models.role'),
            config('laravel-permission.table_names.user_has_roles'),
            'user_id',
            'role_id'
        );
    }
}
