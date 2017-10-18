<?php

namespace App\Models;

/**
 * Class ReviewHasTag
 *
 * @package App\Models
 * @property integer $id
 * @property integer $review_id
 * @property integer $tag_id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 */
class ReviewHasTag extends AppModel
{
    /**
     * @var string
     */
    protected $table = 'review_has_tag';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'review_id',
        'tag_id',
    ];
}
