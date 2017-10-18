<?php

namespace App\Enums;

/**
 * Class ArticleSorting
 * @package App\Enums
 */
class ArticleSorting extends AbstractEnum
{
    const RECENT = 1;
    const POPULAR = 2;
    const SHARED = 3;
    const TITLE_ASC = 4;
    const TITLE_DESC = 5;

    protected static $labels = [
        self::RECENT => 'enums.sorting.articles.recent',
        self::POPULAR => 'enums.sorting.articles.popular',
        self::SHARED => 'enums.sorting.articles.shared',
        self::TITLE_ASC => 'enums.sorting.articles.title_asc',
        self::TITLE_DESC => 'enums.sorting.articles.title_desc',
    ];
}
