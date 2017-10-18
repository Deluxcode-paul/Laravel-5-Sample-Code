<?php

namespace App\Enums;

/**
 * Class WatchFilter
 * @package App\Enums
 */
class WatchFilter extends AbstractEnum
{
    /**
     * @var string
     */
    const P_PAGESIZE = 'p';
    const P_SORT = 's';
    const P_KEYWORD = 'k';
    const P_OWNER_TYPE = 'o';


    /**
     * @var array
     */
    protected static $labels = [
        self::P_PAGESIZE => 'pageSize',
        self::P_SORT => 'sort',
        self::P_KEYWORD => 'keyword',
        self::P_OWNER_TYPE => 'ownerType',

    ];

    public static function labels()
    {
        return static::$labels;
    }
}
