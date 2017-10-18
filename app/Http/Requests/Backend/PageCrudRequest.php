<?php

namespace App\Http\Requests\Backend;

/**
 * Class PageCrudRequest
 * @package App\Http\Requests\Backend
 */
class PageCrudRequest extends AbstractCrudRequest
{
    /**
     * @return string
     */
    protected function setCrudModel()
    {
        return 'App\Models\Page';
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'title' => 'required|string|max:255',
            'headline' => 'string|max:255',
            'image' => 'required|string|max:255|bfm_image',
            'keywords' => 'string|max:255',
            'description' => 'string|max:255',
            'alias' => 'required|string|max:255',
            'layout' => 'required|string|max:255',
        ];
    }
}
