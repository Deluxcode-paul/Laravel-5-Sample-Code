<?php

namespace App\Models;

/**
 * Class ShoppingList
 * @package App\Models
 *
 * @property int $id
 * @property int $user_id
 * @property int $recipe_id
 * @property int $recipe_ingredient_id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 */
class ShoppingList extends AppModel
{
    /**
     * @var string
     */
    protected $table = 'shopping_lists';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'recipe_id',
        'recipe_ingredient_id'
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
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function ingredient()
    {
        return $this->belongsTo('App\Models\RecipeIngredient', 'recipe_ingredient_id');
    }
}
