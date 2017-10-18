<?php

namespace App\Http\Requests\Backend;

/**
 * Class ArticleCategoryCrudRequest
 * @package App\Http\Requests\Backend
 */
class ArticleCategoryCrudRequest extends AbstractCrudRequest
{
    /**
     * @return string
     */
    protected function setCrudModel()
    {
        return 'App\Models\ArticleCategory';
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'title' => 'required|max:255'
        ];
    }
}
