<?php

namespace App\Http\Requests\Backend;

/**
 * Class RecipeImageCrudRequest
 * @package App\Http\Requests\Backend
 */
class RecipeImageCrudRequest extends AbstractCrudRequest
{
    /**
     * @return string
     */
    protected function setCrudModel()
    {
        return 'App\Models\RecipeImage';
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'recipe_id' => 'required',
            'image' => 'required|max:255|bfm_image'
        ];
    }

    /**
     * @return array
     */
    public function messages()
    {
        return [
            'recipe_id.required' => trans('crud.validation.recipe_image.recipe_id.required'),
        ];
    }
}
