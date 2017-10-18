<?php

namespace App\Http\Requests\Backend;

/**
 * Class RecipeCookingCrudRequest
 * @package App\Http\Requests\Backend
 */
class RecipeCookingCrudRequest extends AbstractCrudRequest
{
    /**
     * @return string
     */
    protected function setCrudModel()
    {
        return 'App\Models\RecipeCooking';
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
            'recipe_id' => 'required'
        ];
    }

    /**
     * @return array
     */
    public function messages()
    {
        return [
            'recipe_id.required' => trans('crud.validation.recipe_cooking.recipe_id.required')
        ];
    }
}
