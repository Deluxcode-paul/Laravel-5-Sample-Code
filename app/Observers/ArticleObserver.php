<?php

namespace App\Observers;

use Illuminate\Support\Facades\Cache;

/**
 * Class ArticleObserver
 */
class ArticleObserver
{
    /**
     * @param \App\Models\Article $model
     */
    public function saving($model)
    {
        if (empty($model->is_featured)) {
            $model->is_featured = 0;
        }

        if (empty($model->slug)) {
            $model->slug = $model->generateSlug();
        }
    }

    /**
     * @param \App\Models\Article $model
     */
    public function created($model)
    {
        if ($model->is_banner) {
            Cache::forget('home_banner_items');
        }
    }

    /**
     * @param \App\Models\Article $model
     */
    public function updated($model)
    {
        if ($model->isDirty('is_banner')) {
            Cache::forget('home_banner_items');
        }

        $model->videos()->update([
            'is_featured' => $model->is_featured,
            'user_id' => $model->user_id
        ]);
    }

    /**
     * @param \App\Models\Article $model
     */
    public function deleted($model)
    {
        $model->videos()->delete();
    }
}
