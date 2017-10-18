<?php

namespace App\Http\Controllers\Backend;

use App\Http\Requests\Backend\RecipeCookingCrudRequest;

/**
 * Class RecipeCookingCrud
 * @package App\Http\Controllers\Backend
 */
class RecipeCookingCrud extends AbstractRecipeRelationCrud
{
    /**
     * @var string
     */
    protected $model = 'App\Models\RecipeCooking';

    /**
     * Setup CRUD.
     */
    public function setup()
    {
        parent::setup();

        $this->crud->setRoute('admin/recipes/' . $this->getOwnerId() . '/directions');
        $this->crud->addClause('where', 'recipe_id', '=', $this->getOwnerId());
        $this->crud->setEntityNameStrings(
            trans('crud.labels.recipe_cooking'),
            trans('crud.labels.recipe_cooking')
        );

        $this->addColumns();
        $this->addDefaultSorting();
        $this->addFields();
        $this->crud->addButtonFromView('relation_line', 'bfm_cooking_steps', 'bfm_cooking_steps');
        $this->addFormButtons();
        $this->addRelationButtons();
        $this->addBreadcrumbs();
    }

    /**
     * @param RecipeCookingCrudRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(RecipeCookingCrudRequest $request)
    {
        return parent::storeCrud($request->processWysiwyg());
    }

    /**
     * @param RecipeCookingCrudRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(RecipeCookingCrudRequest $request)
    {
        return parent::updateCrud($request->processWysiwyg());
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
            'name' => 'title',
            'label' => trans('crud.labels.title'),
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
            'value' => $this->getOwnerId()
        ]);
        $this->crud->addField([
            'name' => 'title',
            'label' => $this->getRequiredLabel(trans('crud.labels.title')),
        ]);
        $this->crud->addField([
            'type' => 'tinymce_ingredient',
            'name' => 'description',
            'label' => trans('crud.labels.description'),
        ]);
        $this->crud->addField([
            'type' => 'tinymce_ingredient',
            'name' => 'note',
            'label' => trans('crud.labels.note'),
        ]);
        $this->crud->addField([
            'type' => 'tinymce_ingredient',
            'name' => 'tip',
            'label' => trans('crud.labels.tip'),
        ]);
        $this->crud->addField([
            'type' => 'tinymce_ingredient',
            'name' => 'variation',
            'label' => trans('crud.labels.variation'),
        ]);
    }
}
