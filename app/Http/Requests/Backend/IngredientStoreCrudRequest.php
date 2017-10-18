<?php

namespace App\Http\Requests\Backend;

/**
 * Class IngredientStoreCrudRequest
 * @package App\Http\Requests\Backend
 */
class IngredientStoreCrudRequest extends AbstractCrudRequest
{
    /**
     * @return string
     */
    protected function setCrudModel()
    {
        return 'App\Models\Ingredient';
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'title' => 'required|max:255|unique:ingredients'
        ];
    }
}
