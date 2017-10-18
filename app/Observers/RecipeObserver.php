<?php

namespace App\Observers;

use Illuminate\Support\Facades\Cache;

/**
 * Class RecipeObserver
 */
class RecipeObserver
{
    /**
     * @param \App\Models\Recipe $model
     */
    public function saving($model)
    {
        if (empty($model->difficulty)) {
            $model->difficulty = null;
        }

        if (empty($model->blessing_type_id)) {
            $model->blessing_type_id = null;
        }

        if (empty($model->is_featured)) {
            $model->is_featured = 0;
        }

        if (empty($model->is_banner)) {
            $model->is_banner = 0;
        }

        if (empty($model->is_archive)) {
            $model->is_archive = 0;
        }

        if (empty($model->slug)) {
            $model->slug = $model->generateSlug();
        }
    }

    /**
     * @param \App\Models\Recipe $model
     */
    public function created($model)
    {
        if ($model->is_banner) {
            Cache::forget('home_banner_items');
        }
    }

    /**
     * @param \App\Models\Recipe $model
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
