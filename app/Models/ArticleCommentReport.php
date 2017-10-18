<?php

namespace App\Models;

use App\Observers\ArticleComment\ArticleCommentReportObserver;

/**
 * Class ArticleCommentReport
 *
 * @package App\Models
 * @property integer $id
 * @property integer $article_comment_id
 * @property integer $user_id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 */
class ArticleCommentReport extends AppModel
{
    /**
     * @var string
     */
    protected $table = 'article_comment_reports';

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

        self::observe(new ArticleCommentReportObserver());
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
            ->where('article_comment_id', $question);
    }
}
