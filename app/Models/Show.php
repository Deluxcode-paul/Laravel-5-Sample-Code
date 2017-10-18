<?php

namespace App\Models;

use App\Contracts\HomeBanner;
use App\Contracts\VideoOwner;
use App\Observers\ShowObserver;
use Backpack\CRUD\CrudTrait;
use App\Facades\BfmImage;

/**
 * Class Show
 *
 * @package App\Models
 * @property integer $id
 * @property string $logo
 * @property string $cover
 * @property string $banner
 * @property string $title
 * @property string $description
 * @property boolean $is_featured
 * @property boolean $is_banner
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 */
class Show extends AppModel implements VideoOwner, HomeBanner
{
    use CrudTrait;

    /**
     * @var string
     */
    protected $table = 'shows';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'logo',
        'cover',
        'banner',
        'title',
        'description',
        'is_featured',
        'is_banner'
    ];

    /**
     * The attributes that should be processed as images.
     *
     * @var array
     */
    protected $images = [
        'logo',
        'cover',
        'banner'
    ];

    /**
     * @inheritdoc
     */
    protected static function boot()
    {
        parent::boot();

        self::observe(new ShowObserver());
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function chefs()
    {
        return $this->belongsToMany(
            'App\Models\User',
            'show_has_chef',
            'show_id',
            'chef_id'
        )->withTimestamps();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function videos()
    {
        return $this->morphMany('App\Models\Video', 'owner');
    }

    /**
     * @return string
     */
    public function getUrl()
    {
        return route('watch.show', $this->id);
    }

    /**
     * @return string
     */
    public function getUrlText()
    {
        return trans('pages/video.links.view_full_show');
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
        return str_limit(strip_tags($this->description), 300);
    }

    /**
     * @return string
     */
    public function getType()
    {
        return trans('common.video_owner_types.show');
    }

    /**
     * @return string
     */
    public function getCreator()
    {
        return $this->title;
    }

    /**
     * @return string
     */
    public function getCreatorUrl()
    {
        return $this->getUrl();
    }

    /**
     * @return string
     */
    public function getCreatorImage()
    {
        return $this->getLogoImage();
    }

    /**
     * @return string
     */
    public function getBreadcrumb()
    {
        return 'show';
    }

    /**
     * @return bool
     */
    public function canBeSaved()
    {
        return false;
    }

    /**
     * Return cover image
     * @param string $size
     * @return mixed
     */
    public function getCoverImage($size = 'show_watch_list')
    {
        return BfmImage::init($this->cover)->get($size);
    }

    /**
     * Return banner image
     * @param string $size
     * @return mixed
     */
    public function getBannerImage($size = 'show_banner')
    {
        return BfmImage::init($this->banner)->get($size);
    }

    /**
     * Return logo image
     * @param string $size
     * @return mixed
     */
    public function getLogoImage($size = 'show_logo')
    {
        return BfmImage::init($this->logo)->get($size);
    }

    /**
     * @param string $size
     * @return mixed
     */
    public function getImage($size)
    {
        return $this->getLogoImage($size);
    }

    /**
     * @return string
     */
    public function getDetailsUrlAttribute()
    {
        return route('watch.show', ['show' => $this->id]);
    }

    /**
     * @return string
     */
    public function getChefsString()
    {
        $chefs = [];

        foreach ($this->chefs as $chef) {
            $chefs[] = $chef->fullName;
        }

        return implode(',', $chefs);
    }

    /**
     * Scope for banner data
     * @return  mixed
     */
    public function scopeBanner($query)
    {
        return $query->where('is_banner', true);
    }

    // --- Banner --- //

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
        return trans('pages/home.headings.watching');
    }

    /**
     * @return string
     */
    public function getBannerCategory()
    {
        return '';
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
        return $this->description;
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
        return trans('pages/home.buttons.view_show');
    }

    /**
     * @param string $size
     * @return string
     */
    public function getBannerPicture($size = 'home_banner')
    {
        return $this->getBannerImage($size);
    }

    /**
     * @return boolean
     */
    public function isRecipe()
    {
        return false;
    }

    /**
     * Scope for featured data
     * @return  mixed
     */
    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }
}
