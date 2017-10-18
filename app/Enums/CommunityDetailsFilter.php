<?php

namespace App\Enums;

/**
 * Class CommunityDetailsFilter
 * @package App\Enums
 */
class CommunityDetailsFilter extends AbstractEnum
{
    /**
     * @var string
     */
    const P_PAGESIZE = 'p';
    const P_SORT = 's';


    /**
     * @var array
     */
    protected static $labels = [
        self::P_PAGESIZE => 'pageSize',
        self::P_SORT => 'sort',

    ];

    public static function labels()
    {
        return static::$labels;
    }
}
