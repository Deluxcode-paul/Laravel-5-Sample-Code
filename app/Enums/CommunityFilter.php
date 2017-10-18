<?php

namespace App\Enums;

/**
 * Class CommunityFilter
 * @package App\Enums
 */
class CommunityFilter extends AbstractEnum
{
    /**
     * @var string
     */
    const P_PAGESIZE = 'p';
    const P_SORT = 's';
    const P_KEYWORD = 'k';
    const P_TYPE = 't';


    /**
     * @var array
     */
    protected static $labels = [
        self::P_PAGESIZE => 'pageSize',
        self::P_SORT => 'sort',
        self::P_KEYWORD => 'keyword',
        self::P_TYPE => 'type',

    ];

    public static function labels()
    {
        return static::$labels;
    }
}
