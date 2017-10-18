<?php

namespace App\Models;

/**
 * Class RecipeHasTag
 *
 * @package App\Models
 * @property integer $id
 * @property integer $recipe_id
 * @property integer $tag_id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method static RecipeHasTag whereId($value)
 * @method static RecipeHasTag whereRecipeId($value)
 * @method static RecipeHasTag whereTagId($value)
 * @method static RecipeHasTag whereCreatedAt($value)
 * @method static RecipeHasTag whereUpdatedAt($value)
 * @method static RecipeHasTag enabled()
 * @method static RecipeHasTag featured()
 * @mixin \Eloquent
 */
class RecipeHasTag extends AppModel
{
    /**
     * @var string
     */
    protected $table = 'recipe_has_tag';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'recipe_id',
        'tag_id',
    ];
}
