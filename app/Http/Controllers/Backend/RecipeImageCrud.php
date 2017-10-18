<?php

namespace App\Http\Controllers\Backend;

use App\Http\Requests\Backend\RecipeImageCrudRequest;

/**
 * Class RecipeImageCrud
 * @package App\Http\Controllers\Backend
 */
class RecipeImageCrud extends AbstractRecipeRelationCrud
{
    /**
     * @var string
     */
    protected $model = 'App\Models\RecipeImage';

    /**
     * Setup CRUD.
     */
    public function setup()
    {
        parent::setup();

        $this->crud->setRoute('admin/recipes/' . $this->getOwnerId() . '/images');
        $this->crud->addClause('where', 'recipe_id', '=', $this->getOwnerId());
        $this->crud->setEntityNameStrings(
            trans('crud.labels.recipe_image'),
            trans('crud.labels.recipe_images')
        );

        $this->addColumns();
        $this->addDefaultSorting();
        $this->addFields();
        $this->addFormButtons();
        $this->addRelationButtons();
        $this->addBreadcrumbs();
    }

    /**
     * @param RecipeImageCrudRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(RecipeImageCrudRequest $request)
    {
        return parent::storeCrud($request->processImages());
    }

    /**
     * @param RecipeImageCrudRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(RecipeImageCrudRequest $request)
    {
        return parent::updateCrud($request->processImages());
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
     * Add CRUD columns
     *
     * @return void
     */
    private function addColumns()
    {
        $this->crud->addColumn([
            'type' => 'bfm_image',
            'name' => 'image',
            'label' => trans('crud.labels.image'),
            'attributes' => [
                'data-orderable' => false
            ]
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
            'type' => 'browse',
            'name' => 'image',
            'label' => $this->getRequiredLabel(trans('crud.labels.image')),
            'hint' => $this->getImageHint('1920 x 1200px')
        ]);
    }
}
