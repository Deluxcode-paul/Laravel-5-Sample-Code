<?php

namespace App\Http\Requests\Backend;

/**
 * Class MyRecipeQuestionCrudRequest
 * @package App\Http\Requests\Backend
 */
class MyRecipeQuestionCrudRequest extends AbstractCrudRequest
{
    /**
     * @return string
     */
    protected function setCrudModel()
    {
        return 'App\Models\RecipeQuestion';
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
            'details' => 'required',
        ];
    }

    /**
     * @return array
     */
    public function messages()
    {
        return [
            'user_id.required' => trans('crud.validation.recipe_question.user_id.required'),
            'recipe_id.required' => trans('crud.validation.recipe_question.recipe_id.required')
        ];
    }
}
