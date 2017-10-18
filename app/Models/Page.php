<?php

namespace App\Models;

use App\Facades\BfmImage;
use App\Observers\PageObserver;
use Backpack\CRUD\CrudTrait;
use Bfm\Flex\Cms\Models\Page as FlexPage;

/**
 * Class Page
 * @package App\Models
 *
 * Table columns:
 * @property integer $id
 * @property string $title
 * @property string $headline
 * @property string $image
 * @property string $keywords
 * @property string $description
 * @property string $alias
 * @property string $layout
 * @property bool $enabled
 * @property int $parent_id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property string published_at
 */
class Page extends FlexPage
{
    use CrudTrait;

    /**
     * @inheritdoc
     */
    protected static function boot()
    {
        parent::boot();
        self::observe(new PageObserver());
    }

    /**
     * @return bool
     */
    public function isEditable()
    {
        return true;
    }

    /**
     * Get the images attributes for the model.
     *
     * @return array
     */
    public function getImagesProperty()
    {
        return ['image'];
    }

    /**
     * Get class name without namespace.
     * @return string
     */
    public function getModelName()
    {
        return (new \ReflectionClass($this))->getShortName();
    }

    /**
     * Get table name without model instance
     * @return string
     */
    public static function getTableName()
    {
        return with(new static)->getTable();
    }

    /**
     * @return string
     */
    public function getUrl()
    {
        if ($this->enabled) {
            return $this->url;
        } else {
            return url('admin/cms/pages/preview/' . $this->id);
        }
    }

    /**
     * @param string $size
     * @return string
     */
    public function getImage($size = 'home_banner_alone')
    {
        return BfmImage::init($this->image)->get($size);
    }

    /**
     * @param string $size
     * @param int $blur
     * @return string
     */
    public function getBlurredImage($size = 'home_banner_alone', $blur = 60)
    {
        return BfmImage::init($this->image)->blur($blur)->get($size);
    }
}
