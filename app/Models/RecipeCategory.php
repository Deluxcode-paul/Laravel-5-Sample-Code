<?php

namespace App\Models;

use App\Enums\Search;
use App\Observers\RecipeCategoryObserver;
use Backpack\CRUD\CrudTrait;
use App\Facades\BfmImage;

/**
 * Class RecipeCategory
 *
 * @package App\Models
 *
 * @property integer $id
 * @property string $title
 * @property string $image
 * @property boolean $is_featured
 * @property boolean $is_megamenu
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method static RecipeCategory whereId($value)
 * @method static RecipeCategory whereTitle($value)
 * @method static RecipeCategory whereImage($value)
 * @method static RecipeCategory whereIsFeatured($value)
 * @method static RecipeCategory whereIsMegamenu($value)
 * @method static RecipeCategory whereCreatedAt($value)
 * @method static RecipeCategory whereUpdatedAt($value)
 * @method static RecipeCategory enabled()
 * @method static RecipeCategory featured()
 * @mixin \Eloquent
 */
class RecipeCategory extends AppModel
{
    use CrudTrait;

    /**
     * @var string
     */
    protected $table = 'recipe_categories';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title',
        'image',
        'is_featured',
        'is_megamenu',
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
     * @inheritdoc
     */
    protected static function boot()
    {
        parent::boot();

        self::observe(new RecipeCategoryObserver());
    }

    /**
     * Scope for mega menu categories
     */
    public function scopeMegaMenu($query)
    {
        return $query->where('is_megamenu', true);
    }

    /**
     * Scope for not mega menu categories
     */
    public function scopeNotMegaMenu($query)
    {
        return $query->where('is_megamenu', false);
    }

    /**
     * @param string $size
     * @return mixed
     */
    public function getImage($size = 'recipe_category_mega_menu')
    {
        return BfmImage::init($this->image)->get($size);
    }

    /**
     * @param string $size
     * @param int $blur
     * @return string
     */
    public function getBlurredImage($size = 'recipe_category_mega_menu', $blur = 60)
    {
        return BfmImage::init($this->image)->blur($blur)->get($size);
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
    public function getSubCategoryUrl()
    {
        return route('recipes.list').'?' . Search::P_CATEGORIES . '['.$this->id.']=on';
    }
}
