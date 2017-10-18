<?php

namespace App\Models;

use Backpack\CRUD\CrudTrait;

/**
 * Class Allergen
 *
 * @package App\Models
 * @property integer $id
 * @property string $title
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read Preference[] $preferences
 * @method static Allergen whereId($value)
 * @method static Allergen whereTitle($value)
 * @method static Allergen whereCreatedAt($value)
 * @method static Allergen whereUpdatedAt($value)
 * @method static Allergen enabled()
 * @method static Allergen featured()
 * @mixin \Eloquent
 */
class Allergen extends AppModel
{
    use CrudTrait;

    /**
     * @var string
     */
    protected $table = 'allergens';

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
    public function preferences()
    {
        return $this->belongsToMany(
            'App\Models\Preference',
            'allergen_has_preference',
            'allergen_id',
            'preference_id'
        )->withTimestamps();
    }
}
