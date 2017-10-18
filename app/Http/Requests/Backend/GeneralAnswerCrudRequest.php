<?php

namespace App\Http\Requests\Backend;

/**
 * Class GeneralAnswerCrudRequest
 * @package App\Http\Requests\Backend
 */
class GeneralAnswerCrudRequest extends AbstractCrudRequest
{
    /**
     * @return string
     */
    protected function setCrudModel()
    {
        return 'App\Models\GeneralAnswer';
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
            'question_id' => 'required',
            'details' => 'required',
        ];
    }

    /**
     * @return array
     */
    public function messages()
    {
        return [
            'user_id.required' => trans('crud.validation.general_answer.user_id.required'),
            'question_id.required' => trans('crud.validation.general_answer.question_id.required')
        ];
    }
}
