<?php

namespace App\Http\Requests\Backend;

/**
 * Class UserCrudStoreRequest
 * @package App\Http\Requests\Backend
 */
class UserCrudStoreRequest extends AbstractCrudRequest
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
            'name' => 'required|min:2|max:255|unique:users,name',
            'first_name' => 'required|min:2|max:255',
            'last_name' => 'min:2|max:255',
            'image' => 'string|max:255|bfm_image',
            'email' => 'required|email|max:255|unique:users,email',
            'password' => 'required|min:8|max:255',
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

    /**
     * @return array
     */
    public function messages()
    {
        return [
            'name.required' => trans('crud.validation.user.name.required'),
            'name.max' => trans('crud.validation.user.name.max'),
            'name.min' => trans('crud.validation.user.name.min'),
            'name.unique' => trans('crud.validation.user.name.unique'),
            'email.unique' => trans('crud.validation.user.email.unique'),
        ];
    }
}
