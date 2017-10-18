<?php

namespace App\Http\Requests\Backend;

use App\Models\Ingredient;
use App\Models\IngredientGroup;

/**
 * Class RecipeIngredientCrudRequest
 * @package App\Http\Requests\Backend
 */
class RecipeIngredientCrudRequest extends AbstractCrudRequest
{
    /**
     * @return string
     */
    protected function setCrudModel()
    {
        return 'App\Models\RecipeIngredient';
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'description' => 'required|kosher_required_wysiwyg|max:255',
            'recipe_id' => 'required',
            'ingredient_id' => 'required',
            'ingredient_group_id' => 'required',
        ];
    }

    /**
     * @return array
     */
    public function messages()
    {
        return [
            'recipe_id.required' => trans('crud.validation.recipe_ingredient.recipe_id.required'),
            'ingredient_id.required' => trans('crud.validation.recipe_ingredient.ingredient_id.required'),
            'ingredient_group_id.required' => trans('crud.validation.recipe_ingredient.ingredient_group_id.required')
        ];
    }

    /**
     * @return $this
     */
    public function processIngredientGroup()
    {
        $pkFieldName = $this->getCrudModel()->getKeyName();
        $pkFieldValue = $this->get($pkFieldName);

        if (empty($pkFieldValue)) {
            $httpRequest = \Request::instance();
            $pkFieldValue = $httpRequest->get($pkFieldName);
        }

        $this->merge([$pkFieldName => $pkFieldValue]);
        $ingredientGroupId = null;
        $ingredientGroupTitle = $this->input('ingredient_group_id');

        if (is_string($ingredientGroupTitle)) {
            $ingredientGroup = IngredientGroup::where('title', trim($ingredientGroupTitle))->first();

            if (empty($ingredientGroup)) {
                $ingredientGroup = new IngredientGroup();
                $ingredientGroup->title = trim($ingredientGroupTitle);
                $ingredientGroup->save();
            }

            $ingredientGroupId = $ingredientGroup->id;
        }

        $this->merge(['ingredient_group_id' => $ingredientGroupId]);

        return $this;
    }

    /**
     * @return $this
     */
    public function processIngredient()
    {
        $ingredientId = null;
        $ingredientTitle = $this->input('ingredient_id');

        if (is_string($ingredientTitle)) {
            $ingredient = Ingredient::where('title', trim($ingredientTitle))->first();

            if (empty($ingredient)) {
                $ingredient = new Ingredient();
                $ingredient->title = trim($ingredientTitle);
                $ingredient->save();
            }

            $ingredientId = $ingredient->id;
        }

        $this->merge(['ingredient_id' => $ingredientId]);

        return $this;
    }
}
