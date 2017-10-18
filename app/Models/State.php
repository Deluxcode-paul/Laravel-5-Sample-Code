<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;

/**
 * Class State
 * @package App
 *
 * columns
 * @property integer $id
 * @property string $title
 * @property string $code
 */
class State extends AppModel
{
    /**
     * @var
     */
    protected $table = 'states';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title',
        'code'
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
            $builder->orderBy('title', 'ASC');
        });
    }
}
