<?php

namespace App\Observers;

/**
 * Class PageObserver
 */
class PageObserver
{
    /**
     * @param \App\Models\Page $model
     */
    public function saving($model)
    {
        if (empty($model->keywords)) {
            $model->keywords = '';
        }

        if (empty($model->description)) {
            $model->description = '';
        }
    }
}
