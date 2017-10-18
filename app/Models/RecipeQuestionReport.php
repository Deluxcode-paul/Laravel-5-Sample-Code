<?php

namespace App\Models;

use App\Observers\RecipeQuestion\RecipeQuestionReportObserver;

/**
 * Class RecipeQuestionReport
 *
 * @package App\Models
 * @property integer $id
 * @property integer $recipe_question_id
 * @property integer $user_id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 */
class RecipeQuestionReport extends AppModel
{
    /**
     * @var string
     */
    protected $table = 'recipe_question_reports';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'recipe_question_id',
        'user_id',
    ];

    /**
     * Observer
     */
    protected static function boot()
    {
        parent::boot();

        self::observe(new RecipeQuestionReportObserver());
    }

    /**
     * @param $query
     * @param $user
     * @param $question
     * @return mixed
     */
    public function scopeReported($query, $user, $question)
    {
        return $query->where('user_id', $user)
            ->where('recipe_question_id', $question);
    }
}
