<?php

namespace App\Http\Requests\Backend;

/**
 * Class ArticleCommentCrudRequest
 * @package App\Http\Requests\Backend
 */
class ArticleCommentCrudRequest extends AbstractCrudRequest
{
    /**
     * @return string
     */
    protected function setCrudModel()
    {
        return 'App\Models\ArticleComment';
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
            'article_id' => 'required',
            'title' => 'required|max:255',
            'details' => 'required',
        ];
    }

    /**
     * @return array
     */
    public function messages()
    {
        return [
            'user_id.required' => trans('crud.validation.article_comment.user_id.required'),
            'article_id.required' => trans('crud.validation.article_comment.article_id.required')
        ];
    }
}
