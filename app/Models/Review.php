<?php

namespace App\Models;

use App\Contracts\Taggable;
use App\Contracts\Community\CommunityParentItem;
use App\Observers\RecipeReview\ReviewObserver;
use Backpack\CRUD\CrudTrait;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Models\ReviewReport;

/**
 * Class Review
 *
 * @package App\Models
 * @property integer $id
 * @property integer $recipe_id
 * @property integer $user_id
 * @property string $title
 * @property string $details
 * @property integer $rating
 * @property integer $views
 * @property integer $votes
 * @property integer $reports
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property integer $activity_month
 * @property integer $activity_year
 */
class Review extends AppModel implements Taggable, CommunityParentItem
{
    use CrudTrait;

    /**
     * @var string
     */
    protected $table = 'reviews';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'recipe_id',
        'user_id',
        'title',
        'details',
        'rating',
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
        'replies',
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

        self::observe(new ReviewObserver());
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
    public function recipe()
    {
        return $this->belongsTo('App\Models\Recipe');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function tags()
    {
        return $this->belongsToMany(
            'App\Models\Tag',
            'review_has_tag',
            'review_id',
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
            'review_has_chef',
            'review_id',
            'chef_id'
        )->withTimestamps();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function comments()
    {
        return $this->hasMany('App\Models\ReviewComment');
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
            ->orWhereHas('comments', function ($hasQuery) use ($user) {
                $hasQuery->where('user_id', $user);
            });
    }

    /**
     * @param $query
     * @param $recipeId
     * @return mixed
     */
    public function scopeForRecipe($query, $recipeId)
    {
        return $query->where('recipe_id', $recipeId);
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

    public function getLinkEdit()
    {
        return '#link_to_edit_review';
    }

    public function getLinkAbuse()
    {
        return '#link_to_abuse_review';
    }


    public function userCanEditMe($userId = null)
    {
        $currentUser = Auth::user();
        if (is_null($userId)) {
            $userId = $currentUser->id;
        }
        return $this->user_id == $userId;
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
        return Auth::check() && ReviewReport::reported(Auth::user()->id, $this->id)->count();
    }

    /**
     * @return string
     */
    public function getDetailsUrlAttribute()
    {
        return route('community.recipe-review', $this->id);
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
     * @return int
     */
    public function getRepliesAttribute($value)
    {
        return $this->comments()->count();
    }

    /**
     * @return string
     */
    public function getDataTypeAttribute()
    {
        return 'recipe-review';
    }

    /**
     * @return string
     */
    public function getEditUrlAttribute()
    {
        return route('community.recipe-review.edit', $this->id);
    }

    /**
     * @return string
     */
    public function getUpdateUrlAttribute()
    {
        return route('community.recipe-review.save', $this->id);
    }

    /**
     * @return string
     */
    public function getDeleteUrlAttribute()
    {
        return route('community.recipe-review.delete', $this->id);
    }

    /**
     * @return string
     */
    public function getUrl()
    {
        return route('community.recipe-review', $this->id);
    }
}
