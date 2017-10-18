<?php

namespace App\Http\Requests\Backend;

/**
 * Class CallToActionCrudRequest
 * @package App\Http\Requests\Backend
 */
class CallToActionCrudRequest extends AbstractCrudRequest
{
    /**
     * @return string
     */
    protected function setCrudModel()
    {
        return 'App\Models\CallToAction';
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
            'description' => 'required',
            'button_text' => 'required|max:255',
            'link' => 'required|url|max:255',
            'image' => 'required|max:255|bfm_image'
        ];
    }
}
