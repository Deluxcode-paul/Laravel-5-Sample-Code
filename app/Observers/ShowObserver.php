<?php

namespace App\Observers;

use Illuminate\Support\Facades\Cache;

/**
 * Class ShowObserver
 */
class ShowObserver
{
    /**
     * @param \App\Models\Show $model
     */
    public function saving($model)
    {
        if (empty($model->is_featured)) {
            $model->is_featured = 0;
        }
    }

    /**
     * @param \App\Models\Show $model
     */
    public function created($model)
    {
        if ($model->is_banner) {
            Cache::forget('home_banner_items');
        }
    }

    /**
     * @param \App\Models\Show $model
     */
    public function updated($model)
    {
        if ($model->isDirty('is_banner')) {
            Cache::forget('home_banner_items');
        }

        $model->videos()->update([
            'is_featured' => $model->is_featured
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
