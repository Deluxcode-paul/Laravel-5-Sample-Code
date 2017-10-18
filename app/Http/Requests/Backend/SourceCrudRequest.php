<?php

namespace App\Http\Requests\Backend;

/**
 * Class SourceCrudRequest
 * @package App\Http\Requests\Backend
 */
class SourceCrudRequest extends AbstractCrudRequest
{
    /**
     * @return string
     */
    protected function setCrudModel()
    {
        return 'App\Models\Source';
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
