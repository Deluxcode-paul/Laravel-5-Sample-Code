<?php

namespace App\Models;

use App\Contracts\MediaSlide;
use Backpack\CRUD\CrudTrait;
use App\Facades\BfmImage;

/**
 * Class RecipeImage
 *
 * @package App\Models
 * @property integer $id
 * @property string $image
 * @property integer $recipe_id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method static RecipeImage whereId($value)
 * @method static RecipeImage whereImage($value)
 * @method static RecipeImage whereRecipeId($value)
 * @method static RecipeImage whereIsMain($value)
 * @method static RecipeImage whereCreatedAt($value)
 * @method static RecipeImage whereUpdatedAt($value)
 * @method static RecipeImage enabled()
 * @method static RecipeImage featured()
 * @mixin \Eloquent
 */
class RecipeImage extends AppModel implements MediaSlide
{
    use CrudTrait;

    /**
     * @var string
     */
    protected $table = 'recipe_images';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'image',
        'recipe_id',
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
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function recipe()
    {
        return $this->belongsTo('App\Models\Recipe');
    }


    /**
     * @param string $size
     * @return mixed
     */
    public function getImage($size = 'recipe_list_item')
    {
        return BfmImage::init($this->image)->get($size);
    }

    public function isVideo()
    {
        return false;
    }

    public function getDetailPageUrl()
    {
        return $this->recipe()->getResults()->getUrl();
    }

    /**
     * @param string $size
     * @param int $blur
     * @return string
     */
    public function getBlurredImage($size = 'recipe_list_item', $blur = 60)
    {
        return BfmImage::init($this->image)->blur($blur)->get($size);
    }
}
