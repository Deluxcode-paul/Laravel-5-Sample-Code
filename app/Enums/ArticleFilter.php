<?php

namespace App\Enums;

/**
 * Class ArticleFilter
 * @package App\Enums
 */
class ArticleFilter extends AbstractEnum
{
    /**
     * @var string
     */
    const P_PAGESIZE = 'p';
    const P_SORT = 's';
    const P_KEYWORD = 'k';
    const P_CATEGORY = 'c';
    const P_YEAR = 'y';
    const P_MONTH = 'm';

    /**
     * @var array
     */
    protected static $labels = [
        self::P_PAGESIZE => 'pageSize',
        self::P_SORT => 'sort',
        self::P_KEYWORD => 'keyword',
        self::P_CATEGORY => 'category',
        self::P_YEAR => 'year',
        self::P_MONTH => 'month',
    ];

    public static function labels()
    {
        return static::$labels;
    }
}
