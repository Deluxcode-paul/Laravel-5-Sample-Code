<?php

namespace App\Http\Requests\Backend;

/**
 * Class TagUpdateCrudRequest
 * @package App\Http\Requests\Backend
 */
class TagUpdateCrudRequest extends AbstractCrudRequest
{
    /**
     * @return string
     */
    protected function setCrudModel()
    {
        return 'App\Models\Tag';
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'title' => 'required|max:255|unique:tags,title,'.\Request::get('id')
        ];
    }
}
