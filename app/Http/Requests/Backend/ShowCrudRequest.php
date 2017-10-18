<?php

namespace App\Http\Requests\Backend;

/**
 * Class ShowCrudRequest
 * @package App\Http\Requests\Backend
 */
class ShowCrudRequest extends AbstractCrudRequest
{
    /**
     * @return string
     */
    protected function setCrudModel()
    {
        return 'App\Models\Show';
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
            'logo' => 'required|max:255|bfm_image',
            'cover' => 'required|max:255|bfm_image',
            'banner' => 'required|max:255|bfm_image',
            'description' => 'required|max:360',
        ];
    }
}
