<?php

namespace App\Models;

/**
 * Class RecipeShares
 *
 * @package App\Models
 * @property integer $id
 * @property integer $recipe_id
 * @property integer $shares
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @mixin \Eloquent
 */
class RecipeShares extends AppModel
{
    /**
     * @var string
     */
    protected $table = 'recipe_shares';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'recipe_id',
        'shares',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function recipe()
    {
        return $this->belongsTo('App\Models\Recipe');
    }
}
