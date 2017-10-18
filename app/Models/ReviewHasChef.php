<?php

namespace App\Models;

/**
 * Class ReviewHasChef
 *
 * @package App\Models
 * @property integer $id
 * @property integer $review_id
 * @property integer $chef_id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 */
class ReviewHasChef extends AppModel
{
    /**
     * @var string
     */
    protected $table = 'review_has_chef';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'review_id',
        'chef_id',
    ];
}
