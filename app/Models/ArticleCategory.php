<?php

namespace App\Models;

use App\Enums\ArticleFilter;
use Backpack\CRUD\CrudTrait;

/**
 * Class ArticleCategory
 *
 * @package App\Models
 * @property integer $id
 * @property string $title
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 */
class ArticleCategory extends AppModel
{
    use CrudTrait;

    /**
     * @var string
     */
    protected $table = 'article_categories';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title'
    ];

    /**
     * The attributes that should appends
     * @var array
     */
    protected $appends = [
        'url'
    ];

    /**
     * @return string
     */
    public function getUrl()
    {
        return route('search.lifestyle') . '?' . ArticleFilter::P_CATEGORY . '=' . $this->id;
    }

    /**
     * @return string
     */
    public function getUrlAttribute()
    {
        return $this->getUrl();
    }
}
