<?php

namespace App\Models;

/**
 * Class CommunityNotificationTag
 * @package App\Models
 *
 * @property integer $id
 * @property integer $user_id
 * @property integer $post_id
 * @property string $post_type
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 */
class CommunityNotificationTag extends AppModel
{
    /**
     * @var string
     */
    protected $table = 'community_notification_tags';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'post_id',
        'post_type'
    ];

    /**
     * @var array
     */
    protected $with = [
        'user',
        'post'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphTo
     */
    public function post()
    {
        return $this->morphTo();
    }
}
