<?php

namespace App\Http\Requests\Backend;

/**
 * Class UserCrudUpdateRequest
 * @package App\Http\Requests\Backend
 */
class UserCrudUpdateRequest extends AbstractCrudRequest
{
    /**
     * @return string
     */
    protected function setCrudModel()
    {
        return 'App\Models\User';
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'first_name' => 'required|min:2|max:255',
            'last_name' => 'min:2|max:255',
            'image' => 'string|max:255|bfm_image',
            'password' => 'min:8',
            'roles' => 'required',
            'bio' => 'max:1000',
            'status' => 'max:140',
            'city' => 'max:255',
            'place_of_work' => 'max:255',
            'facebook' => 'url|max:255',
            'instagram' => 'url|max:255',
            'pinterest' => 'url|max:255',
            'twitter' => 'url|max:255',
            'youtube' => 'url|max:255',
            'website' => 'url|max:255',
        ];
    }
}
