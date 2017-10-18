<?php

namespace App\Models;

use App\Observers\ArticleReply\ArticleReplyVoteObserver;

/**
 * Class ArticleReplyVote
 *
 * @package App\Models
 * @property integer $id
 * @property integer $article_reply_id
 * @property integer $user_id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 */
class ArticleReplyVote extends AppModel
{
    /**
     * @var string
     */
    protected $table = 'article_reply_votes';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'article_reply_id',
        'user_id',
    ];

    /**
     * Observer
     */
    protected static function boot()
    {
        parent::boot();

        self::observe(new ArticleReplyVoteObserver());
    }
    /**
     * @param $query
     * @param $user
     * @param $answer
     * @return mixed
     */
    public function scopeVoted($query, $user, $answer)
    {
        return $query->where('user_id', $user)
            ->where('article_reply_id', $answer);
    }
}
