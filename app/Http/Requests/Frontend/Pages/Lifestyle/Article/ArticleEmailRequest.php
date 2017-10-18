<?php

namespace App\Http\Requests\Frontend\Pages\Lifestyle\Article;

use Illuminate\Foundation\Http\FormRequest as FormRequest;

class ArticleEmailRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'email'   => 'required|email|max:255'
        ];
    }
}
