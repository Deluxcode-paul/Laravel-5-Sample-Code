<?php

namespace App\Models;

/**
 * Class RecipeViews
 *
 * @package App\Models
 * @property integer $id
 * @property integer $recipe_id
 * @property integer $views
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @mixin \Eloquent
 */
class RecipeViews extends AppModel
{
    /**
     * @var string
     */
    protected $table = 'recipe_views';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'recipe_id',
        'views',
    ];
    
    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function recipe()
    {
        return $this->belongsTo('App\Models\Recipe');
    }
}
