<?php

namespace App\Http\Requests\Frontend\Community;

use Illuminate\Foundation\Http\FormRequest as FormRequest;

class GeneralAnswerRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules()
    {
        return [
            'details' => 'required',
        ];
    }
}
