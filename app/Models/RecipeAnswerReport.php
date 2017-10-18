<?php

namespace App\Models;

use App\Observers\RecipeAnswer\RecipeAnswerReportObserver;

/**
 * Class RecipeAnswerReport
 *
 * @package App\Models
 * @property integer $id
 * @property integer $recipe_answer_id
 * @property integer $user_id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 */
class RecipeAnswerReport extends AppModel
{
    /**
     * @var string
     */
    protected $table = 'recipe_answer_reports';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'recipe_answer_id',
        'user_id',
    ];

    /**
     * Observer
     */
    protected static function boot()
    {
        parent::boot();

        self::observe(new RecipeAnswerReportObserver());
    }

    /**
     * @param $query
     * @param $user
     * @param $answer
     * @return mixed
     */
    public function scopeReported($query, $user, $answer)
    {
        return $query->where('user_id', $user)
            ->where('recipe_answer_id', $answer);
    }
}
