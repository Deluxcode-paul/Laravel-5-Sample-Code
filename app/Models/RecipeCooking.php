<?php

namespace App\Models;

use Backpack\CRUD\CrudTrait;

/**
 * Class RecipeCooking
 *
 * @package App\Models
 * @property integer $id
 * @property string $title
 * @property integer $recipe_id
 * @property string $description
 * @property string $note
 * @property string $tip
 * @property string $variation
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read Recipe $recipe
 * @method static RecipeCooking whereId($value)
 * @method static RecipeCooking whereTitle($value)
 * @method static RecipeCooking whereRecipeId($value)
 * @method static RecipeCooking whereDescription($value)
 * @method static RecipeCooking whereNote($value)
 * @method static RecipeCooking whereTip($value)
 * @method static RecipeCooking whereCreatedAt($value)
 * @method static RecipeCooking whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class RecipeCooking extends AppModel
{
    use CrudTrait;

    /**
     * @var string
     */
    protected $table = 'recipe_cooking';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title',
        'recipe_id',
        'description',
        'note',
        'tip',
        'variation',
    ];

    /**
     * The attributes that should be processed as wysiwyg content.
     *
     * @var array
     */
    protected $wysiwyg = [
        'description',
        'note',
        'tip',
        'variation'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function recipe()
    {
        return $this->belongsTo('App\Models\Recipe');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function steps()
    {
        return $this->hasMany('App\Models\CookingStep', 'cooking_id');
    }
}
