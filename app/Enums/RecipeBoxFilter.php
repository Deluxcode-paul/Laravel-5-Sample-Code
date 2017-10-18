<?php

namespace App\Enums;

/**
 * Class RecipeBoxFilter
 * @package App\Enums
 */
class RecipeBoxFilter extends AbstractEnum
{
    /**
     * @var string
     */
    const P_PAGESIZE = 'p';
    const P_KEYWORD = 'k';

    /**
     * @var array
     */
    protected static $labels = [
        self::P_PAGESIZE => 'pageSize',
        self::P_KEYWORD => 'keyword',
    ];

    public static function labels()
    {
        return static::$labels;
    }
}
