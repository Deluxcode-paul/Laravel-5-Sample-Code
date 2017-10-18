<?php

namespace App\Http\Requests\Backend;

/**
 * Class VideoCrudRequest
 * @package App\Http\Requests\Backend
 */
class VideoCrudRequest extends AbstractCrudRequest
{
    /**
     * @return string
     */
    protected function setCrudModel()
    {
        return 'App\Models\Video';
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'video' => 'required|url|kosher_video',
            'image' => 'string|max:255|bfm_image',
            'title' => 'max:255'
        ];
    }
}
