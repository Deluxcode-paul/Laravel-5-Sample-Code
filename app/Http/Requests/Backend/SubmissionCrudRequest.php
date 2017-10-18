<?php

namespace App\Http\Requests\Backend;

/**
 * Class SubmissionCrudRequest
 * @package App\Http\Requests\Backend
 */
class SubmissionCrudRequest extends AbstractCrudRequest
{
    /**
     * @return string
     */
    protected function setCrudModel()
    {
        return 'App\Models\Submission';
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'inquiry_type' => 'required|string|max:255',
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'message' => 'required',
        ];
    }
}
