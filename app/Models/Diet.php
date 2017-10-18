<?php

namespace App\Models;

use Backpack\CRUD\CrudTrait;

/**
 * Class Diet
 *
 * @package App\Models
 * @property integer $id
 * @property string $title
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read Preference[] $preferences
 * @method static Diet whereId($value)
 * @method static Diet whereTitle($value)
 * @method static Diet whereCreatedAt($value)
 * @method static Diet whereUpdatedAt($value)
 * @method static Diet enabled()
 * @method static Diet featured()
 * @mixin \Eloquent
 */
class Diet extends AppModel
{
    use CrudTrait;

    /**
     * @var string
     */
    protected $table = 'diets';

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
            'diet_has_preference',
            'diet_id',
            'preference_id'
        )->withTimestamps();
    }
}
