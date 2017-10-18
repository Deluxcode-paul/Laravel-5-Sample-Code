<?php

namespace App\Models;

/**
 * Class DietHasPreference
 *
 * @package App\Models
 * @property integer $id
 * @property integer $diet_id
 * @property integer $preference_id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method static DietHasPreference whereId($value)
 * @method static DietHasPreference whereDietId($value)
 * @method static DietHasPreference wherePreferenceId($value)
 * @method static DietHasPreference whereCreatedAt($value)
 * @method static DietHasPreference whereUpdatedAt($value)
 * @method static DietHasPreference enabled()
 * @method static DietHasPreference featured()
 * @mixin \Eloquent
 */
class DietHasPreference extends AppModel
{
    /**
     * @var string
     */
    protected $table = 'diet_has_preference';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'diet_id',
        'preference_id',
    ];
}
