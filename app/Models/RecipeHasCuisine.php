<?php

namespace App\Models;

/**
 * Class RecipeHasCuisine
 *
 * @package App\Models
 * @property integer $id
 * @property integer $recipe_id
 * @property integer $cuisine_id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method static RecipeHasCuisine whereId($value)
 * @method static RecipeHasCuisine whereRecipeId($value)
 * @method static RecipeHasCuisine whereCuisineId($value)
 * @method static RecipeHasCuisine whereCreatedAt($value)
 * @method static RecipeHasCuisine whereUpdatedAt($value)
 * @method static RecipeHasCuisine enabled()
 * @method static RecipeHasCuisine featured()
 * @mixin \Eloquent
 */
class RecipeHasCuisine extends AppModel
{
    /**
     * @var string
     */
    protected $table = 'recipe_has_cuisine';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'recipe_id',
        'cuisine_id',
    ];
}
