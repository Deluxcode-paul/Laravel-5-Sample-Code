<?php

namespace App\Models;

/**
 * Class CuisineHasPreference
 *
 * @package App\Models
 * @property integer $id
 * @property integer $cuisine_id
 * @property integer $preference_id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method static CuisineHasPreference whereId($value)
 * @method static CuisineHasPreference whereCuisineId($value)
 * @method static CuisineHasPreference wherePreferenceId($value)
 * @method static CuisineHasPreference whereCreatedAt($value)
 * @method static CuisineHasPreference whereUpdatedAt($value)
 * @method static CuisineHasPreference enabled()
 * @method static CuisineHasPreference featured()
 * @mixin \Eloquent
 */
class CuisineHasPreference extends AppModel
{
    /**
     * @var string
     */
    protected $table = 'cuisine_has_preference';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'cuisine_id',
        'preference_id',
    ];
}
