<?php

namespace App\Http\Requests\Frontend\User\Profile\ShoppingLists;

use Illuminate\Foundation\Http\FormRequest as FormRequest;

class RecipeEmailRequest extends FormRequest
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
            'email'   => 'required|email|max:255',
            'recipes'   => 'required|array',
            'recipes.*' => 'integer',
        ];
    }
}
