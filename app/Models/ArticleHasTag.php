<?php

namespace App\Models;

/**
 * Class ArticleHasTag
 *
 * @package App\Models
 * @property integer $id
 * @property integer $article_id
 * @property integer $tag_id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method static ArticleHasTag whereId($value)
 * @method static ArticleHasTag whereRecipeId($value)
 * @method static ArticleHasTag whereTagId($value)
 * @method static ArticleHasTag whereCreatedAt($value)
 * @method static ArticleHasTag whereUpdatedAt($value)
 * @method static ArticleHasTag enabled()
 * @method static ArticleHasTag featured()
 * @mixin \Eloquent
 */
class ArticleHasTag extends AppModel
{
    /**
     * @var string
     */
    protected $table = 'article_has_tag';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'article_id',
        'tag_id',
    ];
}
