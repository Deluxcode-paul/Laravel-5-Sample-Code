<?php

namespace App\Models;

/**
 * Class HolidayHasPreference
 *
 * @package App\Models
 * @property integer $id
 * @property integer $holiday_id
 * @property integer $preference_id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method static HolidayHasPreference whereId($value)
 * @method static HolidayHasPreference whereHolidayId($value)
 * @method static HolidayHasPreference wherePreferenceId($value)
 * @method static HolidayHasPreference whereCreatedAt($value)
 * @method static HolidayHasPreference whereUpdatedAt($value)
 * @method static HolidayHasPreference enabled()
 * @method static HolidayHasPreference featured()
 * @mixin \Eloquent
 */
class HolidayHasPreference extends AppModel
{
    /**
     * @var string
     */
    protected $table = 'holiday_has_preference';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'holiday_id',
        'preference_id',
    ];
}
