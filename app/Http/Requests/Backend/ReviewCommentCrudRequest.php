<?php

namespace App\Http\Requests\Backend;

/**
 * Class ReviewCommentCrudRequest
 * @package App\Http\Requests\Backend
 */
class ReviewCommentCrudRequest extends AbstractCrudRequest
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
            'review_id' => 'required',
            'details' => 'required',
        ];
    }

    /**
     * @return array
     */
    public function messages()
    {
        return [
            'user_id.required' => trans('crud.validation.review_comment.user_id.required'),
            'review_id.required' => trans('crud.validation.review_comment.review_id.required')
        ];
    }
}
