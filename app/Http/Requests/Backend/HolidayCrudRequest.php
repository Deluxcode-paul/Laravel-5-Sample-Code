<?php

namespace App\Http\Requests\Backend;

/**
 * Class HolidayCrudRequest
 * @package App\Http\Requests\Backend
 */
class HolidayCrudRequest extends AbstractCrudRequest
{
    /**
     * @return string
     */
    protected function setCrudModel()
    {
        return 'App\Models\Holiday';
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'title' => 'required|max:255',
            'image' => 'required|max:255|bfm_image',
            'starts_at' => 'date'
        ];
    }

    /**
     * @return array
     */
    public function messages()
    {
        return [
            'starts_at.date' => trans('crud.validation.holiday.starts_at.date'),
        ];
    }
}
