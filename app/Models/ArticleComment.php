<?php

namespace App\Models;

use App\Contracts\Searchable;
use App\Contracts\Taggable;
use App\Contracts\Community\CommunityParentItem;
use App\Observers\ArticleComment\ArticleCommentObserver;
use Backpack\CRUD\CrudTrait;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

/**
 * Class ArticleComment
 *
 * @package App\Models
 * @property integer $id
 * @property integer $article_id
 * @property integer $user_id
 * @property string $title
 * @property string $details
 * @property integer $views
 * @property integer $votes
 * @property integer $reports
 * @property integer $replies
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property integer $activity_month
 * @property integer $activity_year
 */
class ArticleComment extends AppModel implements Taggable, CommunityParentItem, Searchable
{
    use CrudTrait;

    /**
     * @var string
     */
    protected $table = 'article_comments';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'article_id',
        'user_id',
        'title',
        'details',
    ];

    /**
     * @var array
     */
    protected $with = [
        'tags',
        'chefs',
        'user'
    ];

    /**
     * @var array
     */
    protected $appends = [
        'userCanEdit',
        'userCanReport',
        'userCanVote',
        'reported',
        'detailsUrl',
        'hasRating',
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

        self::observe(new ArticleCommentObserver());
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function article()
    {
        return $this->belongsTo('App\Models\Article');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function tags()
    {
        return $this->belongsToMany(
            'App\Models\Tag',
            'article_comment_has_tag',
            'article_comment_id',
            'tag_id'
        )->withTimestamps();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function chefs()
    {
        return $this->belongsToMany(
            'App\Models\User',
            'article_comment_has_chef',
            'article_comment_id',
            'chef_id'
        )->withTimestamps();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function replies()
    {
        return $this->hasMany(
            'App\Models\ArticleReply',
            'article_comment_id'
        );
    }

    /**
     * @return string
     */
    public function getTagsString()
    {
        return $this->tags->pluck('title')->implode(Tag::SEPARATOR);
    }

    /**
     * @return string
     */
    public function getChefsString()
    {
        return $this->chefs->pluck('FullName')->implode(User::SEPARATOR);
    }


    /**
     * @param $query
     * @param $user
     * @return mixed
     */
    public function scopeForUser($query, $user)
    {
        return $query->where('user_id', $user)
            ->orWhereHas('replies', function ($hasQuery) use ($user) {
                $hasQuery->where('user_id', $user);
            });
    }

    /**
     * @param $query
     * @param $article
     * @return mixed
     */
    public function scopeForArticle($query, $article)
    {
        return $query->where('article_id', $article);
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
    public function scopePopular($query)
    {
        return $query->orderBy('views', 'DESC');
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
     * @return mixed
     */
    public function getReportedAttribute()
    {
        return Auth::check() && ArticleCommentReport::reported(Auth::user()->id, $this->id)->count();
    }

    /**
     * @return string
     */
    public function getDetailsUrlAttribute()
    {
        return route('community.article-comment', $this->id);
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
    public function getHasRatingAttribute()
    {
        return $this->hasAttribute('rating');
    }

    /**
     * @param $value
     * @return mixed
     */
    public function getRepliesAttribute($value)
    {
        return $value;
    }

    /**
     * @return string
     */
    public function getDataTypeAttribute()
    {
        return 'article-comment';
    }

    /**
     * @return string
     */
    public function getEditUrlAttribute()
    {
        return route('community.article-comment.edit', $this->id);
    }

    /**
     * @return string
     */
    public function getUpdateUrlAttribute()
    {
        return route('community.article-comment.save', $this->id);
    }

    /**
     * @return string
     */
    public function getDeleteUrlAttribute()
    {
        return route('community.article-comment.delete', $this->id);
    }

    /**
     * @param string $keyword
     * @return string
     */
    public function getSearchUrl($keyword)
    {
        return '';
    }
}
