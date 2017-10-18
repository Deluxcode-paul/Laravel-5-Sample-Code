<?php

namespace App\Observers;

/**
 * Class RecipeObserver
 */
class RecipeCategoryObserver
{
    /**
     * @param \App\Models\RecipeCategory $model
     */
    public function saving($model)
    {
        if (empty($model->is_featured)) {
            $model->is_featured = 0;
        }

        if (empty($model->is_megamenu)) {
            $model->is_megamenu = 0;
        }
    }
}
