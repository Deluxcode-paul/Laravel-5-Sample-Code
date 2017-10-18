<?php

namespace App\Models;

/**
 * Class RecipeHasSource
 *
 * @package App\Models
 * @property integer $id
 * @property integer $recipe_id
 * @property integer $source_id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method static RecipeHasSource whereId($value)
 * @method static RecipeHasSource whereRecipeId($value)
 * @method static RecipeHasSource whereSourceId($value)
 * @method static RecipeHasSource whereCreatedAt($value)
 * @method static RecipeHasSource whereUpdatedAt($value)
 * @method static RecipeHasSource enabled()
 * @method static RecipeHasSource featured()
 * @mixin \Eloquent
 */
class RecipeHasSource extends AppModel
{
    /**
     * @var string
     */
    protected $table = 'recipe_has_source';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'recipe_id',
        'source_id',
    ];
}
