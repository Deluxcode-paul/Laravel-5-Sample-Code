<?php

namespace App\Models;

/**
 * Class RecipeHasCategory
 *
 * @package App\Models
 * @property integer $id
 * @property integer $recipe_id
 * @property integer $category_id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method static RecipeHasCategory whereId($value)
 * @method static RecipeHasCategory whereRecipeId($value)
 * @method static RecipeHasCategory whereCategoryId($value)
 * @method static RecipeHasCategory whereCreatedAt($value)
 * @method static RecipeHasCategory whereUpdatedAt($value)
 * @method static RecipeHasCategory enabled()
 * @method static RecipeHasCategory featured()
 * @mixin \Eloquent
 */
class RecipeHasCategory extends AppModel
{
    /**
     * @var string
     */
    protected $table = 'recipe_has_category';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'recipe_id',
        'category_id',
    ];
}
