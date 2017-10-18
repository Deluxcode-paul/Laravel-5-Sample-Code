<?php

namespace App\Enums;

/**
 * Class RecipesSorting
 * @package App\Enums
 */
class RecipesSorting extends AbstractEnum
{
    const MOST_RECENT = 1;
    const MOST_POPULAR = 2;
    const MOST_SHARED = 3;
    const MOST_TITLE_ASC = 4;
    const MOST_TITLE_DESC = 5;

    protected static $labels = [
        self::MOST_RECENT => 'enums.sorting.recipes.recent',
        self::MOST_POPULAR => 'enums.sorting.recipes.popular',
        self::MOST_SHARED => 'enums.sorting.recipes.shared',
        self::MOST_TITLE_ASC => 'enums.sorting.recipes.title_asc',
        self::MOST_TITLE_DESC => 'enums.sorting.recipes.title_desc'
    ];
}
