<?php

namespace App\Http\Requests\Backend;

/**
 * Class ArticleCrudRequest
 * @package App\Http\Requests\Backend
 */
class ArticleCrudRequest extends AbstractCrudRequest
{
    /**
     * @return string
     */
    protected function setCrudModel()
    {
        return 'App\Models\Article';
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'user_id' => 'required',
            'category_id' => 'required',
            'title' => 'required|max:255',
            'slug' => 'max:255',
            'image' => 'required|max:255|bfm_image',
            'content' => 'required|kosher_required_wysiwyg',
            'published_at' => 'required|date',
        ];
    }

    /**
     * @return array
     */
    public function messages()
    {
        return [
            'user_id.required' => trans('crud.validation.article.user_id.required'),
            'category_id.required' => trans('crud.validation.article.category_id.required'),
            'published_at.required' => trans('crud.validation.article.published_at.required'),
            'published_at.date' => trans('crud.validation.article.published_at.date'),
        ];
    }
}
