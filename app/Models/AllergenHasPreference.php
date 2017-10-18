<?php

namespace App\Models;

/**
 * Class AllergenHasPreference
 *
 * @package App\Models
 * @property integer $id
 * @property integer $allergen_id
 * @property integer $preference_id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method static AllergenHasPreference whereId($value)
 * @method static AllergenHasPreference whereAllergenId($value)
 * @method static AllergenHasPreference wherePreferenceId($value)
 * @method static AllergenHasPreference whereCreatedAt($value)
 * @method static AllergenHasPreference whereUpdatedAt($value)
 * @method static AllergenHasPreference enabled()
 * @method static AllergenHasPreference featured()
 * @mixin \Eloquent
 */
class AllergenHasPreference extends AppModel
{
    /**
     * @var string
     */
    protected $table = 'allergen_has_preference';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'allergen_id',
        'preference_id',
    ];
}
