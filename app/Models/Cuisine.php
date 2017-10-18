<?php

namespace App\Models;

use Backpack\CRUD\CrudTrait;

/**
 * Class Cuisine
 *
 * @package App\Models
 * @property integer $id
 * @property string $title
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read Preference[] $preferences
 * @method static Cuisine whereId($value)
 * @method static Cuisine whereTitle($value)
 * @method static Cuisine whereCreatedAt($value)
 * @method static Cuisine whereUpdatedAt($value)
 * @method static Cuisine enabled()
 * @method static Cuisine featured()
 * @mixin \Eloquent
 */
class Cuisine extends AppModel
{
    use CrudTrait;

    /**
     * @var string
     */
    protected $table = 'cuisines';

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
            'cuisine_has_preference',
            'cuisine_id',
            'preference_id'
        )->withTimestamps();
    }
}
