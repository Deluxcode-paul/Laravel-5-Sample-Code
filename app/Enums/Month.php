<?php

namespace App\Enums;

class Month extends AbstractEnum
{
    /**
     * @var integer
     */
    const JAN = 1;
    const FEB = 2;
    const MAR = 3;
    const APR = 4;
    const MAY = 5;
    const JUN = 6;
    const JUL = 7;
    const AUG = 8;
    const SEP = 9;
    const OCT = 10;
    const NOV = 11;
    const DEC = 12;

    /**
     * @var array
     */
    protected static $labels = [
        self::JAN => 'enums.months.jan',
        self::FEB => 'enums.months.feb',
        self::MAR => 'enums.months.mar',
        self::APR => 'enums.months.apr',
        self::MAY => 'enums.months.may',
        self::JUN => 'enums.months.jun',
        self::JUL => 'enums.months.jul',
        self::AUG => 'enums.months.aug',
        self::SEP => 'enums.months.sep',
        self::OCT => 'enums.months.oct',
        self::NOV => 'enums.months.nov',
        self::DEC => 'enums.months.dec'
    ];
}
