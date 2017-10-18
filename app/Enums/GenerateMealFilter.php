<?php

namespace App\Enums;

/**
 * Class GenerateMealFilter
 * @package App\Enums
 */
class GenerateMealFilter extends AbstractEnum
{
    /**
     * @var string
     */
    const P_PAGESIZE = 'p';
    const P_CATEGORY = 'c';
    const P_COOK_TIME = 't';
    const P_INGREDIENTS = 'i';

    /**
     * @var array
     */
    protected static $labels = [
        self::P_PAGESIZE => 'pageSize',
        self::P_CATEGORY => 'category',
        self::P_COOK_TIME => 'cookTime',
        self::P_INGREDIENTS => 'ingredients',
    ];

    public static function labels()
    {
        return static::$labels;
    }
}
