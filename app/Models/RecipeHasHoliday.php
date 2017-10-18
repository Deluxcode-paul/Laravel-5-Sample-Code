<?php

namespace App\Models;

/**
 * Class RecipeHasHoliday
 *
 * @package App\Models
 * @property integer $id
 * @property integer $recipe_id
 * @property integer $holiday_id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method static RecipeHasHoliday whereId($value)
 * @method static RecipeHasHoliday whereRecipeId($value)
 * @method static RecipeHasHoliday whereHolidayId($value)
 * @method static RecipeHasHoliday whereCreatedAt($value)
 * @method static RecipeHasHoliday whereUpdatedAt($value)
 * @method static RecipeHasHoliday enabled()
 * @method static RecipeHasHoliday featured()
 * @mixin \Eloquent
 */
class RecipeHasHoliday extends AppModel
{
    /**
     * @var string
     */
    protected $table = 'recipe_has_holiday';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'recipe_id',
        'holiday_id',
    ];
}
