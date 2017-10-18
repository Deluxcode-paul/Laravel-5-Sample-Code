<?php

namespace App\Models;

use App\Observers\RecipeObserver;
use Backpack\CRUD\CrudTrait;

/**
 * Class AbstractRecipe
 * @package App\Models
 */
abstract class AbstractRecipe extends AppModel
{
    use CrudTrait;

    /**
     * @var string
     */
    protected $table = 'recipes';

    /**
     * @inheritdoc
     */
    protected static function boot()
    {
        parent::boot();
        self::observe(new RecipeObserver());
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function ingredients()
    {
        return $this->belongsToMany(
            'App\Models\Ingredient',
            'recipe_ingredients',
            'recipe_id',
            'ingredient_id'
        )->withPivot('ingredient_group_id', 'description')->withTimestamps();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function allergens()
    {
        return $this->belongsToMany(
            'App\Models\Allergen',
            'recipe_has_allergen',
            'recipe_id',
            'allergen_id'
        )->withTimestamps();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function blessingType()
    {
        return $this->belongsTo('App\Models\BlessingType');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function categories()
    {
        return $this->belongsToMany(
            'App\Models\RecipeCategory',
            'recipe_has_category',
            'recipe_id',
            'category_id'
        )->withTimestamps();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function cuisines()
    {
        return $this->belongsToMany(
            'App\Models\Cuisine',
            'recipe_has_cuisine',
            'recipe_id',
            'cuisine_id'
        )->withTimestamps();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function diets()
    {
        return $this->belongsToMany(
            'App\Models\Diet',
            'recipe_has_diet',
            'recipe_id',
            'diet_id'
        )->withTimestamps();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function holidays()
    {
        return $this->belongsToMany(
            'App\Models\Holiday',
            'recipe_has_holiday',
            'recipe_id',
            'holiday_id'
        )->withTimestamps();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function preference()
    {
        return $this->belongsTo('App\Models\Preference');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function sources()
    {
        return $this->belongsToMany(
            'App\Models\Source',
            'recipe_has_source',
            'recipe_id',
            'source_id'
        )->withTimestamps();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function tags()
    {
        return $this->belongsToMany(
            'App\Models\Tag',
            'recipe_has_tag',
            'recipe_id',
            'tag_id'
        )->withTimestamps();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function cooking()
    {
        return $this->hasMany('App\Models\RecipeCooking');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function reviews()
    {
        return $this->hasMany('App\Models\Review');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function questions()
    {
        return $this->hasMany('App\Models\RecipeQuestion');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function galleryImages()
    {
        return $this->hasMany('App\Models\RecipeImage');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo('App\Models\User');
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
        return $this->hasOne('App\Models\RecipeViews');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function shares()
    {
        return $this->hasOne('App\Models\RecipeShares');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function boxes()
    {
        return $this->hasMany('App\Models\RecipeBox');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function shoppingLists()
    {
        return $this->hasMany('App\Models\ShoppingList');
    }

    /**
     * @param $query
     * @return mixed
     */
    public function scopePublished($query)
    {
        return $query;
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
     * Scope for not banner data
     * @param $query
     * @return  mixed
     */
    public function scopeNotBanner($query)
    {
        return $query->where('is_banner', false);
    }

    /**
     * Scope for archived data
     * @param $query
     * @return  mixed
     */
    public function scopeArchived($query)
    {
        return $query->where('is_archive', true);
    }

    /**
     * Scope for most popular articles
     * @param $query
     * @return mixed
     */
    public function scopeMostPopular($query)
    {
        return $query->leftJoin('recipe_views', 'recipes.id', '=', 'recipe_views.recipe_id')
            ->orderBy('recipe_views.views', 'DESC')
            ->select('recipes.*', 'recipe_views.views as views');
    }

    /**
     * Scope for most shared articles
     * @param $query
     * @return mixed
     */
    public function scopeMostShared($query)
    {
        return $query->leftJoin('recipe_shares', 'recipes.id', '=', 'recipe_shares.recipe_id')
            ->orderBy('recipe_shares.shares', 'DESC')
            ->select('recipes.*', 'recipe_shares.shares as shares');
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
     * Scope for newest data
     * @param $query
     * @return mixed
     */
    public function scopeNewest($query)
    {
        return $query->orderBy('created_at', 'DESC');
    }

    /**
     * Scope for recent data
     * @param $query
     * @return  mixed
     */
    public function scopeRecent($query)
    {
        return $query->orderBy('updated_at', 'DESC');
    }
}
