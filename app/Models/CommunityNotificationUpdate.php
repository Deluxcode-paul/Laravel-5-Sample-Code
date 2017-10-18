<?php

namespace App\Models;

/**
 * Class CommunityNotificationUpdate
 * @package App\Models
 *
 * @property integer $id
 * @property integer $user_id
 * @property integer $reply_id
 * @property string $reply_type
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 */
class CommunityNotificationUpdate extends AppModel
{
    /**
     * @var string
     */
    protected $table = 'community_notification_updates';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'reply_id',
        'reply_type'
    ];

    /**
     * @var array
     */
    protected $with = [
        'user',
        'reply'
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
    public function reply()
    {
        return $this->morphTo();
    }
}
