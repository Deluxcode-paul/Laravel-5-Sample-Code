<?php

namespace App\Enums;

/**
 * Class ChefsFilter
 * @package App\Enums
 */
class ChefsFilter extends AbstractEnum
{
    /**
     * @var string
     */
    const P_PAGESIZE = 'p';
    const P_SORT = 's';
    const P_KEYWORD = 'k';
    const P_ROLE = 'r';
    const P_STATE = 't';
    const P_COUNTRY = 'c';

    /**
     * @var array
     */
    protected static $labels = [
        self::P_PAGESIZE => 'pageSize',
        self::P_SORT => 'sort',
        self::P_KEYWORD => 'keyword',
        self::P_ROLE => 'role',
        self::P_STATE => 'state',
        self::P_COUNTRY => 'country',
    ];

    public static function labels()
    {
        return static::$labels;
    }
}
