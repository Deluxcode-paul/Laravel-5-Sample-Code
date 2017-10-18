<?php

namespace App\Models;

use App\Observers\GeneralQuestion\GeneralQuestionVoteObserver;

/**
 * Class GeneralQuestionVote
 *
 * @package App\Models
 * @property integer $id
 * @property integer $question_id
 * @property integer $user_id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 */
class GeneralQuestionVote extends AppModel
{
    /**
     * @var string
     */
    protected $table = 'general_question_votes';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'question_id',
        'user_id',
    ];

    /**
     * Observer
     */
    protected static function boot()
    {
        parent::boot();

        self::observe(new GeneralQuestionVoteObserver());
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
            ->where('question_id', $question);
    }
}
