<?php

namespace App\Models;

use Backpack\CRUD\CrudTrait;

/**
 * Class IngredientGroup
 *
 * @package App\Models
 * @property integer $id
 * @property string $title
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method static IngredientGroup whereId($value)
 * @method static IngredientGroup whereTitle($value)
 * @method static IngredientGroup whereCreatedAt($value)
 * @method static IngredientGroup whereUpdatedAt($value)
 * @method static IngredientGroup enabled()
 * @method static IngredientGroup featured()
 * @mixin \Eloquent
 */
class IngredientGroup extends AppModel
{
    use CrudTrait;

    const SEPARATOR = ',';

    /**
     * @var string
     */
    protected $table = 'ingredient_groups';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title',
    ];
}
