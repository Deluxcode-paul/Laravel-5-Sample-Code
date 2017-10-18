<?php

namespace App\Models;

use App\Facades\BfmImage;
use App\Observers\CookingStepObserver;
use Backpack\CRUD\CrudTrait;

/**
 * Class RecipeCooking
 *
 * @package App\Models
 * @property integer $id
 * @property integer $cooking_id
 * @property integer $user_id
 * @property string $description
 * @property string $image
 * @property integer $parent_id
 * @property integer $lft
 * @property integer $rgt
 * @property integer $depth
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read Recipe $cooking
 */
class CookingStep extends AppModel
{
    use CrudTrait;

    /**
     * @var string
     */
    protected $table = 'cooking_steps';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'cooking_id',
        'description',
        'image',
        'parent_id',
        'lft',
        'rgt',
        'depth',
    ];

    /**
     * @var array
     */
    protected $images = [
        'image'
    ];

    /**
     * @var array
     */
    protected $wysiwyg = [
        'description'
    ];

    /**
     * Observer
     */
    protected static function boot()
    {
        parent::boot();
        self::observe(new CookingStepObserver());
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function cooking()
    {
        return $this->belongsTo('App\Models\RecipeCooking', 'cooking_id');
    }

    /**
     * Return image
     * @param string $size
     * @return mixed
     */
    public function getImage($size = 'cooking_step')
    {
        return BfmImage::init($this->image)->get($size);
    }
}
