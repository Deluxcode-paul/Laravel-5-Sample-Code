<?php

namespace App\Http\Requests\Backend;

/**
 * Class MyReviewCommentCrudRequest
 * @package App\Http\Requests\Backend
 */
class MyReviewCommentCrudRequest extends AbstractCrudRequest
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
            'details' => 'required',
        ];
    }
}
