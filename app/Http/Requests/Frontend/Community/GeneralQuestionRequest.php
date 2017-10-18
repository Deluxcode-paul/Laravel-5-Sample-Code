<?php

namespace App\Http\Requests\Frontend\Community;

use Illuminate\Foundation\Http\FormRequest as FormRequest;

class GeneralQuestionRequest extends FormRequest
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
            'title'   => 'required|string|max:255',
            'details' => 'required',
            'tags'    => 'required|array|max:'.config('kosher.max_tags_ask_question'),
            'chefs'   => 'array|max:'.config('kosher.max_chefs_ask_question'),
            'tags.*'  => 'integer',
            'chefs.*' => 'integer',
        ];
    }
}
