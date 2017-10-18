<?php

namespace App\Models;

use App\Observers\ArticleComment\ArticleCommentVoteObserver;

/**
 * Class ArticleCommentVote
 *
 * @package App\Models
 * @property integer $id
 * @property integer $article_comment_id
 * @property integer $user_id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 */
class ArticleCommentVote extends AppModel
{
    /**
     * @var string
     */
    protected $table = 'article_comment_votes';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'article_comment_id',
        'user_id',
    ];

    /**
     * Observer
     */
    protected static function boot()
    {
        parent::boot();

        self::observe(new ArticleCommentVoteObserver());
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
            ->where('article_comment_id', $question);
    }
}
