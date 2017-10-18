<?php

namespace App\Http\Requests\Backend;

/**
 * Class BlessingTypeCrudRequest
 * @package App\Http\Requests\Backend
 */
class BlessingTypeCrudRequest extends AbstractCrudRequest
{
    /**
     * @return string
     */
    protected function setCrudModel()
    {
        return 'App\Models\BlessingType';
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
