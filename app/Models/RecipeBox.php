<?php

namespace App\Models;

/**
 * Class RecipeBox
 * @package App\Models
 *
 * @property integer $id
 * @property integer $user_id
 * @property integer $recipe_id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 */
class RecipeBox extends AppModel
{
    /**
     * @var string
     */
    protected $table = 'recipe_boxes';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'recipe_id'
    ];

    /**
     * @var array
     */
    protected $appends = [
        'detailUrl',
        'title',
        'hasVideo',
        'icon',
        'listImage',
        'creatorUrl',
        'creator',
        'cookingTime',
        'deleteUrl',
    ];

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
     * @return string
     */
    public function getDetailUrlAttribute()
    {
        return $this->recipe->detailUrl;
    }

    /**
     * @return string
     */
    public function getTitleAttribute()
    {
        return $this->recipe->title;
    }

    /**
     * @return mixed
     */
    public function getHasVideoAttribute()
    {
        return $this->recipe->hasVideo;
    }

    /**
     * @return string
     */
    public function getIconAttribute()
    {
        return $this->recipe->icon;
    }

    /**
     * @return string
     */
    public function getListImageAttribute()
    {
        return $this->recipe->listImage;
    }

    /**
     * @return string
     */
    public function getCreatorUrlAttribute()
    {
        return $this->recipe->creatorUrl;
    }

    /**
     * @return string
     */
    public function getCreatorAttribute()
    {
        return $this->recipe->creator;
    }

    /**
     * @return mixed
     */
    public function getCookingTimeAttribute()
    {
        return $this->recipe->cookingTime;
    }

    /**
     * @return string
     */
    public function getDeleteUrlAttribute()
    {
        return '';
    }
}
