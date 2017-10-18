<?php

namespace App\Models;

/**
 * Class ArticleCommentHasTag
 *
 * @package App\Models
 * @property integer $id
 * @property integer $article_comment_id
 * @property integer $tag_id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 */
class ArticleCommentHasTag extends AppModel
{
    /**
     * @var string
     */
    protected $table = 'article_comment_has_tag';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'article_comment_id',
        'tag_id',
    ];
}
