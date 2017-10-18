<?php

namespace App\Http\Requests\Backend;

/**
 * Class DietCrudRequest
 * @package App\Http\Requests\Backend
 */
class DietCrudRequest extends AbstractCrudRequest
{
    /**
     * @return string
     */
    protected function setCrudModel()
    {
        return 'App\Models\Diet';
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
