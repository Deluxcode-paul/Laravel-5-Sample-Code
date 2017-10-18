<?php

namespace App\Http\Requests\Backend;

/**
 * Class RecipeCrudRequest
 * @package App\Http\Requests\Backend
 */
class RecipeCrudRequest extends AbstractCrudRequest
{
    /**
     * @return string
     */
    protected function setCrudModel()
    {
        return 'App\Models\Recipe';
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'title' => 'required|max:255',
            'slug' => 'max:255',
            'image' => 'required|max:255|bfm_image',
            'user_id' => 'required|integer',
            'preference_id' => 'required|integer',
            'cook_time_hours' => 'integer|min:0|required_without:cook_time_minutes',
            'cook_time_minutes' => 'integer|min:0|required_without:cook_time_hours',
            'serving' => 'required|integer|min:0',
            'categories' => 'required|array'
        ];
    }

    /**
     * @return array
     */
    public function messages()
    {
        return [
            'user_id.required' => trans('crud.validation.recipe.user_id.required'),
            'preference_id.required' => trans('crud.validation.recipe.preference_id.required'),
        ];
    }

    public function processCookTime()
    {
        $hours = $this->input('cook_time_hours');
        $minutes = $this->input('cook_time_minutes');
        $this->offsetUnset('cook_time_hours');
        $this->offsetUnset('cook_time_minutes');
        $this->merge(['cook_time' => ($hours * 60) + $minutes]);

        return $this;
    }
}
