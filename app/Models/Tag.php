<?php

namespace App\Models;

use App\Enums\CommunityFilter;
use Backpack\CRUD\CrudTrait;

/**
 * Class Tag
 *
 * @package App\Models
 * @property integer $id
 * @property string $title
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method static Tag whereId($value)
 * @method static Tag whereTitle($value)
 * @method static Tag whereCreatedAt($value)
 * @method static Tag whereUpdatedAt($value)
 * @method static Tag enabled()
 * @method static Tag featured()
 * @mixin \Eloquent
 */
class Tag extends AppModel
{
    use CrudTrait;

    const SEPARATOR = ',';

    /**
     * @var string
     */
    protected $table = 'tags';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title',
    ];

    /**
     * @var array
     */
    protected $appends = [
        'communitySearchUrl'
    ];

    /**
     * @return string
     */
    public function getCommunitySearchUrlAttribute()
    {
        return route('community').'?'.CommunityFilter::P_KEYWORD.'='.urlencode($this->title);
    }
}
