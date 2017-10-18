<?php

namespace App\Models;

/**
 * Class ArticleCommentHasChef
 *
 * @package App\Models
 * @property integer $id
 * @property integer $article_comment_id
 * @property integer $chef_id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 */
class ArticleCommentHasChef extends AppModel
{
    /**
     * @var string
     */
    protected $table = 'article_comment_has_chef';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'article_comment_id',
        'chef_id',
    ];
}
