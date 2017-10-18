<?php

namespace App\Enums;

/**
 * Class CommunitySearchTypes
 * @package App\Enums
 */
class CommunitySearchTypes extends AbstractEnum
{
    /**
     * @var string
     */
    const ALL = 'all';
    const RECIPES = 'recipes';
    const ARTICLE = 'article';
    const GENERAL = 'general';

    /**
     * @var array
     */
    protected static $labels = [
        self::ALL => 'enums.filters.community.all',
        self::RECIPES => 'enums.filters.community.recipes',
        self::ARTICLE => 'enums.filters.community.article',
        self::GENERAL => 'enums.filters.community.general'
    ];
}
