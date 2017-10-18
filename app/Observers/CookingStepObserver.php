<?php

namespace App\Observers;

/**
 * Class CookingStepObserver
 * @package App\Observers
 */
class CookingStepObserver
{
    /**
     * @param \App\Models\CookingStep $model
     */
    public function creating($model)
    {
        $stepsCount = $model->cooking->steps->count();

        $model->parent_id = null;
        $model->lft = intval($stepsCount + 1) * 2;
        $model->rgt = 1 + $model->lft;
        $model->depth = 1;
    }

    /**
     * @param \App\Models\CookingStep $model
     */
    public function saving($model)
    {
        if ($model->cooking->recipe->hasAttribute('user_id')) {
            $model->user_id = $model->cooking->recipe->user_id;
        }
    }
}
