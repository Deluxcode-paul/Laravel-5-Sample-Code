<?php

namespace App\Enums;

/**
 * Class Search
 * @package App\Enums
 */
class Search extends AbstractEnum
{
    /**
     * @var string
     */
    const P_HEADER = 'a';
    const P_PAGESIZE = 'b';
    const P_SORT = 'c';
    const P_PREFERENCES = 'e';
    const P_INGREDIENTS_WITH = 'f';
    const P_INGREDIENTS_WITHOUT = 'g';
    const P_ALLERGENS = 'h';
    const P_DIETS = 'i';
    const P_HOLIDAYS = 'j';
    const P_COOK_TIMES = 's';
    const P_CHEFS = 'l';
    const P_SOURCES = 'm';
    const P_CUISINES = 'n';
    const P_BLESSING_TYPES = 'o';
    const P_CATEGORIES = 'p';
    const P_FEATURED = 'r';
    const P_KEYWORD = 'k';
    const P_SECONDARY ='nd';

    /**
     * @var array
     */
    protected static $labels = [
        self::P_HEADER => 'header',
        self::P_KEYWORD => 'keyword',
        self::P_PREFERENCES => 'preferences',
        self::P_INGREDIENTS_WITH => 'ingredientsWith',
        self::P_INGREDIENTS_WITHOUT => 'ingredientsWithout',
        self::P_ALLERGENS => 'allergens',
        self::P_DIETS => 'diets',
        self::P_HOLIDAYS => 'holidays',
        self::P_COOK_TIMES => 'cookTimes',
        self::P_CHEFS => 'chefs',
        self::P_SOURCES => 'sources',
        self::P_CUISINES => 'cuisines',
        self::P_BLESSING_TYPES => 'blessingTypes',
        self::P_CATEGORIES => 'categories',
        self::P_FEATURED => 'featured',
        self::P_PAGESIZE => 'pageSize',
        self::P_SORT => 'sort',
    ];

    public static function labels()
    {
        return static::$labels;
    }
}
