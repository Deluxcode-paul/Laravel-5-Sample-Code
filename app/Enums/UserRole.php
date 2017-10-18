<?php

namespace App\Enums;

class UserRole extends AbstractEnum
{
    /**
     * @var string
     */
    const ROLE_ADMIN = 1;
    const ROLE_USER = 2;
    const ROLE_PROFESSIONAL_CHEF = 3;
    const ROLE_COMMUNITY_CHEF = 4;

    protected static $labels = [
        self::ROLE_ADMIN             => 'enums.roles.admin',
        self::ROLE_USER              => 'enums.roles.user',
        self::ROLE_PROFESSIONAL_CHEF => 'enums.roles.professional_chef',
        self::ROLE_COMMUNITY_CHEF    => 'enums.roles.community_chef',
    ];
}
