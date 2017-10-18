<?php

namespace App\Enums;

class RecipeDifficulty extends AbstractEnum
{
    /**
     * @var integer
     */
    const EASY = 1;

    /**
     * @var integer
     */
    const MEDIUM = 2;

    /**
     * @var integer
     */
    const HARD = 3;

    protected static $labels = [
        self::EASY => 'enums.easy',
        self::MEDIUM => 'enums.medium',
        self::HARD => 'enums.hard',
    ];
}
