<?php

namespace App\Models;

use App\Contracts\Searchable;
use App\Contracts\Taggable;
use App\Contracts\Community\CommunityParentItem;
use App\Observers\RecipeQuestion\RecipeQuestionObserver;
use Backpack\CRUD\CrudTrait;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Models\RecipeQuestionReport;

/**
 * Class RecipeQuestion
 *
 * @package App\Models
 * @property integer $id
 * @property integer $recipe_id
 * @property integer $user_id
 * @property string $title
 * @property string $details
 * @property integer $views
 * @property integer $votes
 * @property integer $reports
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property integer $activity_month
 * @property integer $activity_year
 */
class RecipeQuestion extends AppModel implements Taggable, CommunityParentItem, Searchable
{
    use CrudTrait;

    /**
     * @var string
     */
    protected $table = 'recipe_questions';

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

        self::observe(new RecipeQuestionObserver());
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
            'recipe_question_has_tag',
            'recipe_question_id',
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
            'recipe_question_has_chef',
            'recipe_question_id',
            'chef_id'
        )->withTimestamps();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function answers()
    {
        return $this->hasMany(
            'App\Models\RecipeAnswer',
            'recipe_question_id'
        );
    }

    /**
     * @return string
     */
    public function getTagsString()
    {
        $tags = [];
        foreach ($this->tags as $tag) {
            $tags[] = $tag->title;
        }

        return implode(Tag::SEPARATOR, $tags);
    }

    /**
     * @param $query
     * @param $user
     * @return mixed
     */
    public function scopeForUser($query, $user)
    {
        return $query->where('user_id', $user)
            ->orWhereHas('answers', function ($hasQuery) use ($user) {
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
        return Auth::check() && RecipeQuestionReport::reported(Auth::user()->id, $this->id)->count();
    }

    /**
     * @return string
     */
    public function getDetailsUrlAttribute()
    {
        return route('community.recipe-question', $this->id);
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
     * @return string
     */
    public function getChefsString()
    {
        return $this->chefs->pluck('FullName')->implode(User::SEPARATOR);
    }

    /**
     * @param $value
     * @return int
     */
    public function getRepliesAttribute($value)
    {
        return $this->answers()->count();
    }

    /**
     * @return string
     */
    public function getDataTypeAttribute()
    {
        return 'recipe-question';
    }

    /**
     * @return string
     */
    public function getEditUrlAttribute()
    {
        return route('community.recipe-question.edit', $this->id);
    }

    /**
     * @return string
     */
    public function getUpdateUrlAttribute()
    {
        return route('community.recipe-question.save', $this->id);
    }

    /**
     * @return string
     */
    public function getDeleteUrlAttribute()
    {
        return route('community.recipe-question.delete', $this->id);
    }

    /**
     * @return string
     */
    public function getUrl()
    {
        return route('community.recipe-question', $this->id);
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
