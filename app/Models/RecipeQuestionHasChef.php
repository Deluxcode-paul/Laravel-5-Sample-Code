<?php

namespace App\Models;

/**
 * Class RecipeQuestionHasChef
 *
 * @package App\Models
 * @property integer $id
 * @property integer $recipe_question_id
 * @property integer $chef_id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 */
class RecipeQuestionHasChef extends AppModel
{
    /**
     * @var string
     */
    protected $table = 'recipe_question_has_chef';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'recipe_question_id',
        'chef_id',
    ];
}
