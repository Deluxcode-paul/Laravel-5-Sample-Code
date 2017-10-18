<?php

namespace App\Http\Requests\Backend;

/**
 * Class ArticleReplyCrudRequest
 * @package App\Http\Requests\Backend
 */
class ArticleReplyCrudRequest extends AbstractCrudRequest
{
    /**
     * @return string
     */
    protected function setCrudModel()
    {
        return 'App\Models\ArticleReply';
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
            'article_comment_id' => 'required',
            'details' => 'required',
        ];
    }

    /**
     * @return array
     */
    public function messages()
    {
        return [
            'user_id.required' => trans('crud.validation.article_reply.user_id.required'),
            'article_comment_id.required' => trans('crud.validation.article_reply.article_comment_id.required')
        ];
    }
}
