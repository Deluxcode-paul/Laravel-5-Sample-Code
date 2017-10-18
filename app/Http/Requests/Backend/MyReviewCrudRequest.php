<?php

namespace App\Http\Requests\Backend;

/**
 * Class MyReviewCrudRequest
 * @package App\Http\Requests\Backend
 */
class MyReviewCrudRequest extends AbstractCrudRequest
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
            'title' => 'required|max:255',
            'details' => 'required',
            'rating' => 'required|integer|min:1|max:5',
        ];
    }

}
