<?php

namespace App\Observers;

/**
 * Class VideoObserver
 */
class VideoObserver
{
    /**
     * @param \App\Models\Video $model
     */
    public function saving($model)
    {
        $model->is_featured = $model->owner->is_featured;

        if ($model->owner->hasAttribute('user_id')) {
            $model->user_id = $model->owner->user_id;
        }
    }
}
