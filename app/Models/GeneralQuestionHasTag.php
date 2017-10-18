<?php

namespace App\Models;

/**
 * Class GeneralQuestionHasTag
 *
 * @package App\Models
 * @property integer $id
 * @property integer $question_id
 * @property integer $tag_id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 */
class GeneralQuestionHasTag extends AppModel
{
    /**
     * @var string
     */
    protected $table = 'general_question_has_tag';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'question_id',
        'tag_id',
    ];
}
