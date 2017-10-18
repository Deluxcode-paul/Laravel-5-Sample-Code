<?php

namespace App\Models;

use Backpack\CRUD\CrudTrait;
use Illuminate\Database\Eloquent\Builder;

/**
 * Class Ingredient
 *
 * @package App\Models
 * @property integer $id
 * @property string $title
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method static Ingredient whereId($value)
 * @method static Ingredient whereTitle($value)
 * @method static Ingredient whereCreatedAt($value)
 * @method static Ingredient whereUpdatedAt($value)
 * @method static Ingredient enabled()
 * @method static Ingredient featured()
 * @mixin \Eloquent
 */
class Ingredient extends AppModel
{
    use CrudTrait;

    const SEPARATOR = ',';

    /**
     * @var string
     */
    protected $table = 'ingredients';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title',
    ];

    /**
     * The "booting" method of the model.
     *
     * @return void
     */
    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope('orderByTitle', function (Builder $builder) {
            $builder->orderBy('title', 'asc');
        });
    }
}
