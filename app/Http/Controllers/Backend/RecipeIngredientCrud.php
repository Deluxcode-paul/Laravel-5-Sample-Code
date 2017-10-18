<?php

namespace App\Http\Controllers\Backend;

use App\Http\Requests\Backend\RecipeIngredientCrudRequest;
use App\Models\Ingredient;
use App\Models\IngredientGroup;

/**
 * Class RecipeIngredientCrud
 * @package App\Http\Controllers\Backend
 */
class RecipeIngredientCrud extends AbstractRecipeRelationCrud
{
    /**
     * @var string
     */
    protected $model = 'App\Models\RecipeIngredient';

    /**
     * Setup CRUD.
     */
    public function setup()
    {
        parent::setup();

        $this->crud->setRoute('admin/recipes/' . $this->getOwnerId() . '/ingredients');
        $this->crud->addClause('where', 'recipe_id', '=', $this->getOwnerId());
        $this->crud->setEntityNameStrings(
            trans('crud.labels.recipe_ingredient'),
            trans('crud.labels.recipe_ingredients')
        );

        $this->addColumns();
        $this->addDefaultSorting();
        $this->addFields();
        $this->addFormButtons();
        $this->addRelationButtons();
        $this->addBreadcrumbs();
    }

    /**
     * @param RecipeIngredientCrudRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(RecipeIngredientCrudRequest $request)
    {
        return parent::storeCrud($request->processIngredientGroup()->processIngredient());
    }

    /**
     * @param RecipeIngredientCrudRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(RecipeIngredientCrudRequest $request)
    {
        return parent::updateCrud($request->processIngredientGroup()->processIngredient());
    }

    /**
     * Restrict access to content by user ID for non-admin users
     */
    protected function filterByUser()
    {
        $this->crud->addClause('whereHas', 'recipe', function ($query) {
            $query->where('user_id', '=', $this->currentUser->id);
        });
    }

    /**
     * Set CRUD filters
     */
    protected function setFilters()
    {
        $this->addFilter([
            'type' => 'select2',
            'name' => 'ingredient_group_id',
            'label' => trans('crud.labels.ingredient_group'),
            'options' => IngredientGroup::all()->sortBy('title')->pluck('title', 'id'),
            'placeholder' => trans('crud.placeholders.any')
        ]);
        $this->addFilter([
            'type' => 'select2',
            'name' => 'ingredient_id',
            'label' => trans('crud.labels.ingredient'),
            'options' => Ingredient::all()->sortBy('title')->pluck('title', 'id'),
            'placeholder' => trans('crud.placeholders.any')
        ]);
        $this->addFilter([
            'name' => 'description',
            'label' => trans('crud.labels.description')
        ]);
    }

    /**
     * Add CRUD columns
     *
     * @return void
     */
    private function addColumns()
    {
        $this->crud->addColumn([
            'type' => 'select',
            'name' => 'ingredient_group_id',
            'label' => trans('crud.labels.ingredient_group'),
            'entity' => 'ingredientGroup',
            'attribute' => 'title',
            'attributes' => [
                'data-orderable' => false
            ]
        ]);
        $this->crud->addColumn([
            'type' => 'select',
            'name' => 'ingredient_id',
            'label' => trans('crud.labels.ingredient'),
            'entity' => 'ingredient',
            'attribute' => 'title',
            'attributes' => [
                'data-orderable' => false
            ]
        ]);
        $this->crud->addColumn([
            'name' => 'description',
            'label' => trans('crud.labels.description'),
        ]);
        $this->crud->addColumn([
            'type' => 'datetime',
            'name' => 'updated_at',
            'label' => trans('crud.labels.updated_at'),
        ]);
    }

    /**
     * Add CRUD fields
     *
     * @return void
     */
    private function addFields()
    {
        $this->crud->addField([
            'type' => 'hidden',
            'name' => 'recipe_id',
            'value' => $this->getOwnerId(),
            'attributes' => [
                'id' => 'js-recipeId'
            ]
        ]);
        $this->crud->addField([
            'type' => 'bfm_ingredient_group',
            'name' => 'ingredient_group_id',
            'label' => $this->getRequiredLabel(trans('crud.labels.ingredient_group')),
            'entity' => 'ingredientGroup',
            'attribute' => 'title',
            'model' => 'App\Models\IngredientGroup',
            'attributes' => [
                'placeholder' => trans('crud.placeholders.select_ingredient_group')
            ],
            'hint' => trans('crud.hints.select_or_create')
        ]);
        $this->crud->addField([
            'type' => 'bfm_ingredient',
            'name' => 'ingredient_id',
            'label' => $this->getRequiredLabel(trans('crud.labels.ingredient')),
            'entity' => 'ingredient',
            'attribute' => 'title',
            'model' => 'App\Models\Ingredient',
            'attributes' => [
                'placeholder' => trans('crud.placeholders.select_ingredient')
            ],
            'hint' => trans('crud.hints.select_or_create')
        ]);
        $this->crud->addField([
            'type' => 'tinymce_ingredient',
            'name' => 'description',
            'label' => $this->getRequiredLabel(trans('crud.labels.description')),
        ]);
    }
}
