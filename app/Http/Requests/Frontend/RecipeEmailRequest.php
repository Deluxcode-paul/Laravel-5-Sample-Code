<?php

namespace App\Http\Requests\Frontend;

use Illuminate\Foundation\Http\FormRequest as FormRequest;

class RecipeEmailRequest extends FormRequest
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
            'email' => 'required|email|max:255',
        ];
    }
}
