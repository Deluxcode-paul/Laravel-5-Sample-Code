<?php

namespace App\Models;

/**
 * Class Preference
 *
 * @package App\Models
 * @property integer $id
 * @property string $title
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Allergen[] $allergens
 * @method static Preference whereId($value)
 * @method static Preference whereTitle($value)
 * @method static Preference whereCreatedAt($value)
 * @method static Preference whereUpdatedAt($value)
 * @method static Preference enabled()
 * @method static Preference featured()
 * @mixin \Eloquent
 */
class Preference extends AppModel
{
    /**
     * @var string
     */
    protected $table = 'preferences';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function allergens()
    {
        return $this->belongsToMany(
            'App\Models\Allergen',
            'allergen_has_preference',
            'preference_id',
            'allergen_id'
        )->withTimestamps();
    }
}
