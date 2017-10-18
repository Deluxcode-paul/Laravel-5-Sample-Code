<?php

namespace App\Http\Requests\Frontend\User\Profile\ShoppingLists;

use Illuminate\Foundation\Http\FormRequest as FormRequest;
use Illuminate\Support\Facades\Auth;

/**
 * Class DeleteIngredientRequest
 * @package App\Http\Requests\Frontend\User\Profile\ShoppingLists
 */
class DeleteIngredientRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Auth::user()->checkIngredientOwner($this->input('id'));
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'id' => 'required|integer',
            'page' => 'integer'
        ];
    }
}
