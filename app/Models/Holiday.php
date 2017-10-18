<?php

namespace App\Models;

use App\Enums\Search;
use Backpack\CRUD\CrudTrait;
use Carbon\Carbon;
use App\Facades\BfmImage;

/**
 * Class Holiday
 *
 * @package App\Models
 *
 * @property integer $id
 * @property string $title
 * @property string $image
 * @property boolean $is_megamenu
 * @property \Carbon\Carbon $starts_at
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read Preference[] $preferences
 * @method static Holiday whereId($value)
 * @method static Holiday whereTitle($value)
 * @method static Holiday whereIsMegamenu($value)
 * @method static Holiday whereCreatedAt($value)
 * @method static Holiday whereUpdatedAt($value)
 * @method static Holiday enabled()
 * @method static Holiday featured()
 * @mixin \Eloquent
 */
class Holiday extends AppModel
{
    use CrudTrait;

    /**
     * @var string
     */
    protected $table = 'holidays';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title',
        'image',
        'is_megamenu',
        'starts_at',
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [
        'starts_at'
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
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function preferences()
    {
        return $this->belongsToMany(
            'App\Models\Preference',
            'holiday_has_preference',
            'holiday_id',
            'preference_id'
        )->withTimestamps();
    }

    /**
     * @param string $value
     * @return string
     */
    public function getStartsAtAttribute($value)
    {
        if ($value) {
            return Carbon::createFromFormat(
                config('database.datetime_format'),
                $value
            )->format(config('backpack.base.default_date_format'));
        }

        return $value;
    }

    /**
     * Scope for nearest holidays
     *
     * @param $query
     * @return mixed
     */
    public function scopeNearest($query)
    {
        return $query->where('starts_at', '>=', Carbon::now()->toDateTimeString())
                     ->orderBy('starts_at', 'asc');
    }

    /**
     * Scope for holidays without date
     *
     * @param $query
     * @return mixed
     */
    public function scopeWithoutDate($query)
    {
        return $query->where('starts_at', '=', null);
    }

    /**
     * @param string $size
     * @return mixed
     */
    public function getImage($size = 'holiday_mega_menu')
    {
        return BfmImage::init($this->image)->get($size);
    }

    /**
     * @param string $size
     * @param int $blur
     * @return string
     */
    public function getBlurredImage($size = 'holiday_mega_menu', $blur = 60)
    {
        return BfmImage::init($this->image)->blur($blur)->get($size);
    }

    /**
     * @return string
     */
    public function getSubCategoryUrl()
    {
        return route('recipes.list').'?' . Search::P_HOLIDAYS . '['.$this->id.']=on';
    }
}
