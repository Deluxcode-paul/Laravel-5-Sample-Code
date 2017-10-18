<?php

namespace App\Models;

/**
 * Class GeneralQuestionHasChef
 *
 * @package App\Models
 * @property integer $id
 * @property integer $question_id
 * @property integer $chef_id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 */
class GeneralQuestionHasChef extends AppModel
{
    /**
     * @var string
     */
    protected $table = 'general_question_has_chef';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'question_id',
        'chef_id',
    ];
}
