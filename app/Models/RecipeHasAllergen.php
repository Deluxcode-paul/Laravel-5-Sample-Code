<?php

namespace App\Models;

/**
 * Class RecipeHasAllergen
 *
 * @package App\Models
 * @property integer $id
 * @property integer $recipe_id
 * @property integer $allergen_id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method static RecipeHasAllergen whereId($value)
 * @method static RecipeHasAllergen whereRecipeId($value)
 * @method static RecipeHasAllergen whereAllergenId($value)
 * @method static RecipeHasAllergen whereCreatedAt($value)
 * @method static RecipeHasAllergen whereUpdatedAt($value)
 * @method static RecipeHasAllergen enabled()
 * @method static RecipeHasAllergen featured()
 * @mixin \Eloquent
 */
class RecipeHasAllergen extends AppModel
{
    /**
     * @var string
     */
    protected $table = 'recipe_has_allergen';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'recipe_id',
        'allergen_id',
    ];
}
