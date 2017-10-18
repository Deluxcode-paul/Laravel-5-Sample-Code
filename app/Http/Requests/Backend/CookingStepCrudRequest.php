<?php

namespace App\Http\Requests\Backend;

/**
 * Class CookingStepCrudRequest
 * @package App\Http\Requests\Backend
 */
class CookingStepCrudRequest extends AbstractCrudRequest
{
    /**
     * @return string
     */
    protected function setCrudModel()
    {
        return 'App\Models\CookingStep';
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'description' => 'required|kosher_required_wysiwyg',
            'cooking_id' => 'required'
        ];
    }

    /**
     * @return array
     */
    public function messages()
    {
        return [
            'cooking_id.required' => trans('crud.validation.cooking_step.cooking_id.required')
        ];
    }
}
