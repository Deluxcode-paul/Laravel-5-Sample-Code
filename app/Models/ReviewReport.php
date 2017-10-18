<?php

namespace App\Models;

use App\Observers\RecipeReview\ReviewReportObserver;

/**
 * Class ReviewReport
 *
 * @package App\Models
 * @property integer $id
 * @property integer $review_id
 * @property integer $user_id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 */
class ReviewReport extends AppModel
{
    /**
     * @var string
     */
    protected $table = 'review_reports';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'review_id',
        'user_id',
    ];

    /**
     * Observer
     */
    protected static function boot()
    {
        parent::boot();

        self::observe(new ReviewReportObserver());
    }

    /**
     * @param $query
     * @param $user
     * @param $review
     * @return mixed
     */
    public function scopeReported($query, $user, $review)
    {
        return $query->where('user_id', $user)
            ->where('review_id', $review);
    }
}
