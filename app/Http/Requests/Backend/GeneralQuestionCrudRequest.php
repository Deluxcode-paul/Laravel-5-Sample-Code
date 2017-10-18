<?php

namespace App\Http\Requests\Backend;

/**
 * Class GeneralQuestionCrudRequest
 * @package App\Http\Requests\Backend
 */
class GeneralQuestionCrudRequest extends AbstractCrudRequest
{
    /**
     * @return string
     */
    protected function setCrudModel()
    {
        return 'App\Models\GeneralQuestion';
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
            'user_id.required' => trans('crud.validation.general_question.user_id.required')
        ];
    }

}
