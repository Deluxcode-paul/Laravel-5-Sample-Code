<?php

namespace App\Http\Requests\Backend;

/**
 * Class RecipeAnswerCrudRequest
 * @package App\Http\Requests\Backend
 */
class RecipeAnswerCrudRequest extends AbstractCrudRequest
{
    /**
     * @return string
     */
    protected function setCrudModel()
    {
        return 'App\Models\ReviewComment';
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'user_id' => 'required',
            'recipe_question_id' => 'required',
            'details' => 'required',
        ];
    }

    /**
     * @return array
     */
    public function messages()
    {
        return [
            'user_id.required' => trans('crud.validation.recipe_answer.user_id.required'),
            'recipe_question_id.required' => trans('crud.validation.recipe_answer.recipe_question_id.required')
        ];
    }
}
