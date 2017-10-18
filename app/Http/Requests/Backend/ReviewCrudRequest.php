<?php

namespace App\Http\Requests\Backend;

/**
 * Class ReviewCrudRequest
 * @package App\Http\Requests\Backend
 */
class ReviewCrudRequest extends AbstractCrudRequest
{
    /**
     * @return string
     */
    protected function setCrudModel()
    {
        return 'App\Models\Review';
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
            'recipe_id' => 'required',
            'title' => 'required|max:255',
            'details' => 'required',
            'rating' => 'required|integer|min:1|max:5',
        ];
    }

    /**
     * @return array
     */
    public function messages()
    {
        return [
            'user_id.required' => trans('crud.validation.review.user_id.required'),
            'recipe_id.required' => trans('crud.validation.review.recipe_id.required')
        ];
    }

}
