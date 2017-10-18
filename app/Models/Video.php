<?php

namespace App\Models;

use App\Contracts\MediaSlide;
use App\Contracts\Searchable;
use App\Contracts\Taggable;
use App\Enums\WatchFilter;
use App\Facades\BfmImage;
use App\Facades\BfmVideo;
use Backpack\CRUD\CrudTrait;
use App\Observers\VideoObserver;

/**
 * Class Video
 *
 * @package App\Models
 * @property integer $id
 * @property integer $owner_id
 * @property string $owner_type
 * @property integer $user_id
 * @property boolean $is_featured
 * @property string $video
 * @property string $video_type
 * @property string $video_id
 * @property string $image
 * @property string $title
 * @property string $description
 * @property integer $episode
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 */
class Video extends AppModel implements MediaSlide, Taggable, Searchable
{
    use CrudTrait;

    /**
     * @var string
     */
    protected $table = 'videos';

    /**
     * @var bool
     */
    protected $polymorphic = true;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'owner_id',
        'owner_type',
        'video',
        'image',
        'title',
        'description',
        'episode',
        'is_featured',
        'video_id',
        'video_type'
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
     * The attributes that should be processed as videos.
     *
     * @var array
     */
    protected $videos = [
        'video'
    ];

    /**
     * @var array
     */
    protected $appends = [
        'detailsUrl',
        'listImage',
        'creator',
        'creatorUrl',
        'creatorImage',
        'type',
        'icon'
    ];

    /**
     * Observer
     */
    protected static function boot()
    {
        parent::boot();

        self::observe(new VideoObserver());
    }

    /**
     * Get owner entity.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphTo
     */
    public function owner()
    {
        return $this->morphTo();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function show()
    {
        return $this->belongsTo('App\Models\Show', 'owner_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function tags()
    {
        return $this->belongsToMany(
            'App\Models\Tag',
            'video_has_tag',
            'video_id',
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
     * @param string $size
     * @return string
     */
    public function getImage($size = 'video_list')
    {
        return BfmImage::init($this->image)->get($size);
    }

    /**
     * @param string $size
     * @param int $blur
     * @return string
     */
    public function getBlurredImage($size = 'video_list', $blur = 60)
    {
        return BfmImage::init($this->image)->blur($blur)->get($size);
    }

    /**
     * @return string
     */
    public function getListImageAttribute()
    {
        return $this->getImage('video_list');
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

    public function isVideo()
    {
        return true;
    }

    public function getDetailPageUrl()
    {
        return route('watch.video', [$this->id]);
    }

    /**
     * @param $value
     * @return mixed
     */
    public function getTitleAttribute($value)
    {
        if (!$value && isset($this->owner)) {
            $value = $this->owner->title;
        }

        return $value;
    }

    /**
     * @param $value
     * @return mixed
     */
    public function getDescriptionAttribute($value)
    {
        if (!$value && isset($this->owner)) {
            $value = $this->owner->getDescription();
        }

        return str_limit(strip_tags($value), 300);
    }

    /**
     * @return mixed
     */
    public function getTypeAttribute()
    {
        if (isset($this->owner)) {
            return $this->owner->getType();
        } else {
            return null;
        }
    }

    /**
     * @return mixed
     */
    public function getCreatorAttribute()
    {
        if (isset($this->owner)) {
            return $this->owner->getCreator();
        } else {
            return null;
        }
    }

    /**
     * @return mixed
     */
    public function getCreatorUrlAttribute()
    {
        if (isset($this->owner)) {
            return $this->owner->getCreatorUrl();
        } else {
            return null;
        }
    }

    /**
     * @return mixed
     */
    public function getCreatorImageAttribute()
    {
        if (isset($this->owner)) {
            return $this->owner->getCreatorImage();
        } else {
            return null;
        }
    }

    /**
     * @return string
     */
    public function getDetailsUrlAttribute()
    {
        return route('watch.video', ['video  ' => $this->id]);
    }

    /**
     * @return string
     */
    public function getOwnerUrlAttribute()
    {
        if (isset($this->owner)) {
            return $this->owner->getUrl();
        } else {
            return null;
        }
    }

    /**
     * @return string
     */
    public function getOwnerUrlTextAttribute()
    {
        if (isset($this->owner)) {
            return $this->owner->getUrlText();
        } else {
            return null;
        }
    }

    /**
     * @return mixed
     */
    public function canBeSaved()
    {
        if (isset($this->owner)) {
            return $this->owner->canBeSaved();
        } else {
            return false;
        }
    }

    /**
     * Scope for recent data
     * @return  mixed
     */
    public function scopeRecent($query)
    {
        return $query->orderBy('updated_at', 'DESC');
    }

    /**
     * Scope for featured data
     * @return  mixed
     */
    public function scopePublished($query)
    {
        return $query;
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

    /**
     * @return string
     */
    public function getEmbedUrl()
    {
        return BfmVideo::getEmbedUrl($this->video_type, $this->video_id);
    }

    /**
     * @return string
     */
    public function getShortUrl()
    {
        return $this->detailsUrl;
    }

    /**
     * @param string $keyword
     * @return string
     */
    public function getSearchUrl($keyword)
    {
        return route('search.watch') . '?' . WatchFilter::P_KEYWORD . '=' . urlencode(trim($keyword));
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
     * @return string
     */
    public function getUrl()
    {
        return $this->detailsUrl;
    }
}
