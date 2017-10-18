<?php

namespace App\Http\Requests\Backend;

/**
 * Class ArticleVideoCrudRequest
 * @package App\Http\Requests\Backend
 */
class ArticleVideoCrudRequest extends AbstractCrudRequest
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
            'owner_id' => 'required',
            'owner_type' => 'required',
            'video' => 'required|url|kosher_video',
            'image' => 'string|max:255|bfm_image',
            'title' => 'max:255'
        ];
    }
}
