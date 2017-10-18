<?php

namespace App\Models;

use Backpack\CRUD\CrudTrait;

/**
 * Class BlessingType
 *
 * @package App\Models
 * @property integer $id
 * @property string $title
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method static BlessingType whereId($value)
 * @method static BlessingType whereTitle($value)
 * @method static BlessingType whereCreatedAt($value)
 * @method static BlessingType whereUpdatedAt($value)
 * @method static BlessingType enabled()
 * @method static BlessingType featured()
 * @mixin \Eloquent
 */
class BlessingType extends AppModel
{
    use CrudTrait;

    /**
     * @var string
     */
    protected $table = 'blessing_types';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title',
    ];
}
