<?php

namespace App\Http\Requests\Backend;

/**
 * Class RecipeCategoryCrudRequest
 * @package App\Http\Requests\Backend
 */
class RecipeCategoryCrudRequest extends AbstractCrudRequest
{
    /**
     * @return string
     */
    protected function setCrudModel()
    {
        return 'App\Models\RecipeCategory';
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'title' => 'required|max:255',
            'image' => 'required|max:255|bfm_image'
        ];
    }
}
