<?php

namespace App\Models;

use Backpack\CRUD\CrudTrait;

/**
 * Class Source
 *
 * @package App\Models
 * @property integer $id
 * @property string $title
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method static Source whereId($value)
 * @method static Source whereTitle($value)
 * @method static Source whereCreatedAt($value)
 * @method static Source whereUpdatedAt($value)
 * @method static Source enabled()
 * @method static Source featured()
 * @mixin \Eloquent
 */
class Source extends AppModel
{
    use CrudTrait;

    /**
     * @var string
     */
    protected $table = 'sources';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title',
    ];
}
