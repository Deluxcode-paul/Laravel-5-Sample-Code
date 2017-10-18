<?php

namespace App\Enums;

class VideoOwners extends AbstractEnum
{
    /**
     * @var string
     */
    const RECIPE  = 'App\Models\Recipe';
    const ARTICLE = 'App\Models\Article';
    const SHOW    = 'App\Models\Show';


    protected static $labels = [
        self::RECIPE  => 'enums.video_owners.recipe',
        self::ARTICLE => 'enums.video_owners.article',
        self::SHOW    => 'enums.video_owners.show',
    ];
}
