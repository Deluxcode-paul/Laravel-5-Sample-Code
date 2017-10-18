<?php

namespace App\Http\Requests\Backend;

/**
 * Class IngredientUpdateCrudRequest
 * @package App\Http\Requests\Backend
 */
class IngredientUpdateCrudRequest extends AbstractCrudRequest
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
            'title' => 'required|max:255|unique:ingredients,title,'.\Request::get('id')
        ];
    }
}
