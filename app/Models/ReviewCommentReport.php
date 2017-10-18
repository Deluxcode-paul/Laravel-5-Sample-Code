<?php

namespace App\Models;

use App\Observers\ReviewComment\ReviewCommentReportObserver;

/**
 * Class ReviewCommentReport
 *
 * @package App\Models
 * @property integer $id
 * @property integer $review_comment_id
 * @property integer $user_id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 */
class ReviewCommentReport extends AppModel
{
    /**
     * @var string
     */
    protected $table = 'review_comment_reports';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'review_comment_id',
        'user_id',
    ];

    /**
     * Observer
     */
    protected static function boot()
    {
        parent::boot();

        self::observe(new ReviewCommentReportObserver());
    }

    /**
     * @param $query
     * @param $user
     * @param $comment
     * @return mixed
     */
    public function scopeReported($query, $user, $comment)
    {
        return $query->where('user_id', $user)
            ->where('review_comment_id', $comment);
    }
}
