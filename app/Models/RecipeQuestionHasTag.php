<?php

namespace App\Models;

/**
 * Class RecipeQuestionHasTag
 *
 * @package App\Models
 * @property integer $id
 * @property integer $recipe_question_id
 * @property integer $tag_id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 */
class RecipeQuestionHasTag extends AppModel
{
    /**
     * @var string
     */
    protected $table = 'recipe_question_has_tag';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'recipe_question_id',
        'tag_id',
    ];
}
