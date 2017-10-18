<?php

namespace App\Enums;

class ChefSorting extends AbstractEnum
{
    /**
     * @var string
     */
    const NAME_ASC  = 'name_asc';
    const NAME_DESC = 'name_desc';


    protected static $labels = [
        self::NAME_ASC  => 'enums.sorting.chefs.name_asc',
        self::NAME_DESC => 'enums.sorting.chefs.name_desc',
    ];
}
