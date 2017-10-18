<?php

namespace App\Http\Requests\Backend;

/**
 * Class CuisineCrudRequest
 * @package App\Http\Requests\Backend
 */
class CuisineCrudRequest extends AbstractCrudRequest
{
    /**
     * @return string
     */
    protected function setCrudModel()
    {
        return 'App\Models\Cuisine';
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
