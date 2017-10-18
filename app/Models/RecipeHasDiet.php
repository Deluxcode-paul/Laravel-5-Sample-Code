<?php

namespace App\Models;

/**
 * Class RecipeHasDiet
 *
 * @package App\Models
 * @property integer $id
 * @property integer $recipe_id
 * @property integer $diet_id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method static RecipeHasDiet whereId($value)
 * @method static RecipeHasDiet whereRecipeId($value)
 * @method static RecipeHasDiet whereDietId($value)
 * @method static RecipeHasDiet whereCreatedAt($value)
 * @method static RecipeHasDiet whereUpdatedAt($value)
 * @method static RecipeHasDiet enabled()
 * @method static RecipeHasDiet featured()
 * @mixin \Eloquent
 */
class RecipeHasDiet extends AppModel
{
    /**
     * @var string
     */
    protected $table = 'recipe_has_diet';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'recipe_id',
        'diet_id',
    ];
}
