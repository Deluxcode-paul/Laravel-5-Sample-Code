<?php

namespace App\Http\Requests\Backend;

/**
 * Class AllergenCrudRequest
 * @package App\Http\Requests\Backend
 */
class AllergenCrudRequest extends AbstractCrudRequest
{
    /**
     * @return string
     */
    protected function setCrudModel()
    {
        return 'App\Models\Allergen';
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [];
    }
}
