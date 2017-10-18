<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;

/**
 * Class Country
 * @package App
 *
 * columns
 * @property integer $id
 * @property string $title
 */
class Country extends AppModel
{
    /**
     * @var
     */
    protected $table = 'countries';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title'
    ];

    /**
     * The "booting" method of the model.
     *
     * @return void
     */
    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope('sort', function (Builder $builder) {
            $builder->orderBy('id', 'ASC');
        });
    }
}
