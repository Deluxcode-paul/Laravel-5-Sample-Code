<?php

namespace App\Enums;

/**
 * Class MyRecipesFilter
 * @package App\Enums
 */
class MyRecipesFilter extends AbstractEnum
{
    /**
     * @var string
     */
    const P_PAGESIZE = 'p';

    /**
     * @var array
     */
    protected static $labels = [
        self::P_PAGESIZE => 'pageSize',
    ];

    public static function labels()
    {
        return static::$labels;
    }
}