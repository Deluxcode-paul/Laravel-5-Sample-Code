<?php

namespace App\Http\Requests\Frontend\Pages\Contact;

use Illuminate\Foundation\Http\FormRequest as FormRequest;

/**
 * Class SubmissionRequest
 * @package App\Http\Requests\Frontend\Pages\Contact
 */
class SubmissionRequest extends FormRequest
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
            'inquiry_type' => 'required|string|max:255',
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'message' => 'required',
        ];
    }
}
