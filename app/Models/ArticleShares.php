<?php

namespace App\Models;

/**
 * Class ArticleHasTag
 *
 * @package App\Models
 * @property integer $id
 * @property integer $article_id
 * @property integer $shares
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @mixin \Eloquent
 */
class ArticleShares extends AppModel
{
    /**
     * @var string
     */
    protected $table = 'article_shares';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'article_id',
        'shares',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function article()
    {
        return $this->belongsTo('App\Models\Article');
    }
}
