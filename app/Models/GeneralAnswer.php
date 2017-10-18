<?php

namespace App\Models;

use App\Observers\GeneralAnswer\GeneralAnswerObserver;
use App\Contracts\Community\CommunityChildItem;
use Backpack\CRUD\CrudTrait;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

/**
 * Class GeneralAnswer
 *
 * @package App\Models
 * @property integer $id
 * @property integer $question_id
 * @property integer $user_id
 * @property string $details
 * @property integer $votes
 * @property integer $reports
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 */
class GeneralAnswer extends AppModel implements CommunityChildItem
{
    use CrudTrait;

    /**
     * @var string
     */
    protected $table = 'general_answers';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'question_id',
        'user_id',
        'details',
    ];

    /**
     * @var array
     */
    protected $with = [
        'user'
    ];

    /**
     * @var array
     */
    protected $appends = [
        'userCanEdit',
        'userCanReport',
        'userCanVote',
        'dataType',
        'editUrl',
        'publishedAt'
    ];

    /**
     * @inheritdoc
     */
    protected static function boot()
    {
        parent::boot();

        self::observe(new GeneralAnswerObserver());
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function question()
    {
        return $this->belongsTo(
            'App\Models\GeneralQuestion',
            'question_id'
        );
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    /**
     * @param $query
     * @return mixed
     */
    public function scopeRecent($query)
    {
        return $query->orderBy('updated_at', 'DESC');
    }

    /**
     * @param $query
     * @return mixed
     */
    public function scopeVotes($query)
    {
        return $query->orderBy('votes', 'DESC');
    }

    /**
     * @return mixed
     */
    public function getUserCanEditAttribute()
    {
        return Auth::check() && Auth::user()->can('edit', $this);
    }

    /**
     * @return mixed
     */
    public function getUserCanReportAttribute()
    {
        return Auth::check() && Auth::user()->can('report', $this);
    }

    /**
     * @return mixed
     */
    public function getUserCanVoteAttribute()
    {
        return Auth::check() && Auth::user()->can('vote', $this);
    }

    /**
     * @return string
     */
    public function getPublishedAtAttribute()
    {
        return Carbon::createFromFormat(
            config('database.datetime_format'),
            $this->updated_at
        )->format(config('kosher.date_formats.FjY'));
    }

    /**
     * @return string
     */
    public function getDataTypeAttribute()
    {
        return 'community-answer';
    }

    /**
     * @return string
     */
    public function getEditUrlAttribute()
    {
        return route('community.community-answer.edit', $this->id);
    }

    /**
     * @return string
     */
    public function getUpdateUrlAttribute()
    {
        return route('community.community-answer.save', $this->id);
    }

    /**
     * @return string
     */
    public function getDeleteUrlAttribute()
    {
        return route('community.community-answer.delete', $this->id);
    }

    /**
     * @return string
     */
    public function getOwnerUrl()
    {
        return $this->question->detailsUrl;
    }
}
