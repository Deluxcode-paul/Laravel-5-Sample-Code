<?php

namespace App\Models;

use App\Observers\RecipeQuestion\RecipeQuestionVoteObserver;

/**
 * Class RecipeQuestionVote
 *
 * @package App\Models
 * @property integer $id
 * @property integer $recipe_question_id
 * @property integer $user_id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 */
class RecipeQuestionVote extends AppModel
{
    /**
     * @var string
     */
    protected $table = 'recipe_question_votes';

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

        self::observe(new RecipeQuestionVoteObserver());
    }

    /**
     * @param $query
     * @param $user
     * @param $question
     * @return mixed
     */
    public function scopeVoted($query, $user, $question)
    {
        return $query->where('user_id', $user)
            ->where('recipe_question_id', $question);
    }
}
