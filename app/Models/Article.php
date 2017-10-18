<?php

namespace App\Models;

use App\Contracts\HomeBanner;
use App\Contracts\Searchable;
use App\Contracts\Taggable;
use App\Contracts\VideoOwner;
use App\Enums\ArticleFilter;
use App\Facades\BfmImage;
use App\Observers\ArticleObserver;
use Backpack\CRUD\CrudTrait;
use Carbon\Carbon;

/**
 * Class Article
 *
 * @package App\Models
 * @property integer $id
 * @property integer $user_id
 * @property integer $category_id
 * @property string $title
 * @property string $slug
 * @property string $image
 * @property string $content
 * @property boolean $is_featured
 * @property boolean $is_banner
 * @property \Carbon\Carbon $published_at
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 */
class Article extends AppModel implements VideoOwner, Taggable, HomeBanner, Searchable
{
    use CrudTrait;

    const SHORT_TEXT_LENGTH = 90;

    /**
     * @var string
     */
    protected $table = 'articles';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'category_id',
        'title',
        'slug',
        'image',
        'content',
        'is_featured',
        'is_banner',
        'published_at'
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [
        'published_at'
    ];

    /**
     * The attributes that should be processed as images.
     *
     * @var array
     */
    protected $images = [
        'image'
    ];

    /**
     * @var array
     */
    protected $wysiwyg = [
        'content'
    ];

    /**
     * The attributes that should appends
     * @var array
     */
    protected $appends = [
        'url',
        'listImage',
        'searchListImage',
        'published',
        'shortContent',
        'hasVideo',
        'icon'
    ];

    /**
     * The attributes that should appends
     * @var array
     */
    protected $with = [
        'category',
        'user'
    ];

    /**
     * @inheritdoc
     */
    protected static function boot()
    {
        parent::boot();
        self::observe(new ArticleObserver());
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function tags()
    {
        return $this->belongsToMany(
            'App\Models\Tag',
            'article_has_tag',
            'article_id',
            'tag_id'
        )->withTimestamps();
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
    public function category()
    {
        return $this->belongsTo('App\Models\ArticleCategory');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function videos()
    {
        return $this->morphMany('App\Models\Video', 'owner');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function views()
    {
        return $this->hasOne('App\Models\ArticleViews');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function shares()
    {
        return $this->hasOne('App\Models\ArticleShares');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function comments()
    {
        return $this->hasMany('App\Models\ArticleComment');
    }

    /**
     * Return list image
     * @return string
     */
    public function getListImageAttribute()
    {
        return $this->getImage('articles.list');
    }

    /**
     * Return list image
     * @return string
     */
    public function getSearchListImageAttribute()
    {
        return $this->getImage('articles.search_list');
    }

    /**
     * @param string $size
     * @return string
     */
    public function getImage($size = 'article_home_page_big')
    {
        return BfmImage::init($this->image)->get($size);
    }

    /**
     * @param string $size
     * @param int $blur
     * @return string
     */
    public function getBlurredImage($size = 'article_home_page_big', $blur = 60)
    {
        return BfmImage::init($this->image)->blur($blur)->get($size);
    }

    /**
     * @param string $value
     * @return string
     */
    public function getPublishedAtAttribute($value)
    {
        if ($value) {
            return Carbon::createFromFormat(
                config('database.datetime_format'),
                $value
            )->format(config('backpack.base.default_date_format')); // DO NOT CHANGE - it's used in backpack crud
        }

        return $value;
    }

    /**
     * @return string
     */
    public function getPublishedAttribute()
    {
        return Carbon::createFromFormat(
            config('backpack.base.default_date_format'),
            $this->published_at
        )->format(config('kosher.date_formats.FjY'));
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
     * Scope for banner data
     * @param $query
     * @return  mixed
     */
    public function scopeBanner($query)
    {
        return $query->where('is_banner', true);
    }

    /**
     * Scope for published data
     * @param $query
     * @return  mixed
     */
    public function scopePublished($query)
    {
        return $query->whereDate('published_at', '<=', Carbon::today()->toDateString());
    }

    /**
     * Scope for recent data
     * @param $query
     * @return  mixed
     */
    public function scopeRecent($query)
    {
        return $query->orderBy('published_at', 'DESC');
    }

    /**
     * Scope for related articles
     * @param $query
     * @param $article
     * @return mixed
     */
    public function scopeRelated($query, $article)
    {
        return $query->where('articles.id', '<>', $article->id)
            ->whereHas('tags', function ($query) use ($article) {
                $query->whereIn('tags.id', $article->tags->pluck('id'));
            });
    }

    /**
     * Return image
     * @return mixed
     */
    public function getIconAttribute()
    {
        $icon = '';

        if (isset($this->user) && $this->user->isTopChef()) {
            $icon = 'top_chef';
        }

        return $icon;
    }

    /**
     * Return URL for details page
     * @return string
     */
    public function getUrlAttribute()
    {
        return $this->getUrl();
    }

    /**
     * @return mixed
     */
    public function getHasVideoAttribute()
    {
        return boolval($this->videos()->count() > 0);
    }

    /**
     * Scope for most popular articles
     * @param $query
     * @return mixed
     */
    public function scopeMostPopular($query)
    {
        return $query->leftJoin('article_views', 'articles.id', '=', 'article_views.article_id')
            ->orderBy('article_views.views', 'DESC')
            ->select('articles.*', 'article_views.views as views');
    }

    /**
     * Scope for most shared articles
     * @param $query
     * @return mixed
     */
    public function scopeMostShared($query)
    {
        return $query->leftJoin('article_shares', 'articles.id', '=', 'article_shares.article_id')
            ->orderBy('article_shares.shares', 'DESC')
            ->select('articles.*', 'article_shares.shares as shares');
    }

    /**
     * @return string
     */
    public function getUrl()
    {
        return route('article', [$this->id, $this->slug]);
    }

    /**
     * @return string
     */
    public function getShortUrl()
    {
        return route('article.short', [$this->id]);
    }

    /**
     * @return string
     */
    public function getUrlText()
    {
        return trans('pages/video.links.view_full_article');
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return str_limit(strip_tags($this->content), 300);
    }

    /**
     * @return string
     */
    public function getType()
    {
        return trans('common.video_owner_types.article');
    }

    /**
     * @return string
     */
    public function getCreator()
    {
        return $this->user->fullName;
    }

    /**
     * @return string
     */
    public function getCreatorUrl()
    {
        return $this->user->publicProfileUrl;
    }

    /**
     * @return string
     */
    public function getCreatorImage()
    {
        return $this->user->getImage();
    }

    /**
     * @return string
     */
    public function getBreadcrumb()
    {
        return 'article';
    }

    /**
     * @return bool
     */
    public function canBeSaved()
    {
        return false;
    }

    /**
     * @return string
     */
    public function getShortContentAttribute()
    {
        return str_limit(html_entity_decode(strip_tags($this->content), ENT_QUOTES), self::SHORT_TEXT_LENGTH);
    }

    /**
     * Scope for featured data
     * @return  mixed
     */
    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    /**
     * Scope for not featured data
     * @return  mixed
     */
    public function scopeNotFeatured($query)
    {
        return $query->where('is_featured', false);
    }


    public function getCommentsPage()
    {
        $perPage = config('kosher.pagination.article_detail_page_comments');
        return ArticleComment::forArticle($this->id)
            ->recent()
            ->paginate($perPage);
    }

    /**
     * @return string
     */
    public function getBannerHeading()
    {
        return trans('pages/home.headings.whats');
    }

    /**
     * @return string
     */
    public function getBannerSubheading()
    {
        return trans('pages/home.headings.reading');
    }

    /**
     * @return string
     */
    public function getBannerCategory()
    {
        if ($this->category) {
            return $this->category->title;
        } else {
            return '';
        }
    }

    /**
     * @return string
     */
    public function getBannerTitle()
    {
        return $this->title;
    }

    /**
     * @return string
     */
    public function getBannerDescription()
    {
        return $this->content;
    }

    /**
     * @return string
     */
    public function getBannerUrl()
    {
        return $this->getUrl();
    }

    /**
     * @return string
     */
    public function getBannerButton()
    {
        return trans('pages/home.buttons.view_article');
    }

    /**
     * @param string $size
     * @return string
     */
    public function getBannerPicture($size = 'home_banner')
    {
        return $this->getImage($size);
    }

    /**
     * @return boolean
     */
    public function isRecipe()
    {
        return false;
    }

    /**
     * @param string $keyword
     * @return string
     */
    public function getSearchUrl($keyword)
    {
        return route('search.lifestyle') . '?' . ArticleFilter::P_KEYWORD . '=' . urlencode(trim($keyword));
    }

    /**
     * @return string
     */
    public function generateSlug()
    {
        return str_slug($this->title, '-');
    }

    /**
     * @return string
     */
    public function getCategoryUrl()
    {
        return route('lifestyle') . '?' . ArticleFilter::P_CATEGORY . '=' . $this->category_id;
    }
}
