<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Schema;
use Illuminate\Support\Facades\DB;

/**
 * Class AppModel
 * @package App\Models
 */
abstract class AppModel extends Model
{
    /**
     * @var bool
     */
    protected $editable = true;

    /**
     * @var bool
     */
    protected $polymorphic = false;

    /**
     * The attributes that should be processed as images.
     *
     * @var array
     */
    protected $images = [];

    /**
     * The attributes that should be processed as videos.
     *
     * @var array
     */
    protected $videos = [];

    /**
     * The attributes that should be processed as wysiwyg content.
     *
     * @var array
     */
    protected $wysiwyg = [];

    /**
     * Scope for random data
     * @param $query
     * @return mixed
     */
    public function scopeRandom($query)
    {
        return $query->orderBy(DB::raw('RAND()'));
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
     * Get class name without namespace.
     * @return string
     */
    public function getModelName()
    {
        return (new \ReflectionClass($this))->getShortName();
    }

    /**
     * Get the images attributes for the model.
     *
     * @return array
     */
    public function getImagesProperty()
    {
        return $this->images;
    }

    /**
     * Get the dates attributes for the model (without "created_at" and "updated_at").
     *
     * @return array
     */
    public function getDatesProperty()
    {
        return $this->dates;
    }

    /**
     * @return bool
     */
    public function isPolymorphic()
    {
        return $this->polymorphic;
    }

    /**
     * Get the videos attributes for the model.
     *
     * @return array
     */
    public function getVideosProperty()
    {
        return $this->videos;
    }

    public function getWysiwygProperty()
    {
        return $this->wysiwyg;
    }

    /**
     * Checks if attribute exists
     * @param $attr
     * @return bool
     */
    public function hasAttribute($attr)
    {
        return array_key_exists($attr, $this->attributes);
    }

    /**
     * @return bool
     */
    public function isEditable()
    {
        return $this->editable;
    }
}
