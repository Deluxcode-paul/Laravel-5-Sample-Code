<?php

namespace App\Models;

use Backpack\CRUD\CrudTrait;

/**
 * Class RecipeIngredient
 *
 * @package App\Models
 * @property integer $id
 * @property integer $recipe_id
 * @property integer $ingredient_group_id
 * @property integer $ingredient_id
 * @property string $description
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read Ingredient $ingredient
 * @property-read IngredientGroup $ingredientGroup
 * @property-read Recipe $recipe
 * @method static RecipeIngredient whereId($value)
 * @method static RecipeIngredient whereRecipeId($value)
 * @method static RecipeIngredient whereIngredientGroupId($value)
 * @method static RecipeIngredient whereIngredientId($value)
 * @method static RecipeIngredient whereDescription($value)
 * @method static RecipeIngredient whereCreatedAt($value)
 * @method static RecipeIngredient whereUpdatedAt($value)
 * @method static RecipeIngredient enabled()
 * @method static RecipeIngredient featured()
 * @mixin \Eloquent
 */
class RecipeIngredient extends AppModel
{
    use CrudTrait;

    /**
     * @var string
     */
    protected $table = 'recipe_ingredients';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'recipe_id',
        'ingredient_group_id',
        'ingredient_id',
        'description',
    ];

    /**
     * @var array
     */
    protected $wysiwyg = [
        'description'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function ingredient()
    {
        return $this->belongsTo('App\Models\Ingredient');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function ingredientGroup()
    {
        return $this->belongsTo('App\Models\IngredientGroup');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function recipe()
    {
        return $this->belongsTo('App\Models\Recipe');
    }
}
