<?php

namespace App\Http\Controllers\Backend;

use App\Http\Requests\Backend\IngredientStoreCrudRequest;
use App\Http\Requests\Backend\IngredientUpdateCrudRequest;

/**
 * Class IngredientCrud
 * @package App\Http\Controllers\Backend
 */
class IngredientCrud extends AbstractCrud
{
    /**
     * @var string
     */
    protected $model = 'App\Models\Ingredient';

    /**
     * Setup CRUD.
     */
    public function setup()
    {
        parent::setup();

        $this->crud->setRoute('admin/ingredients');
        $this->crud->setEntityNameStrings(
            trans('crud.labels.ingredient'),
            trans('crud.labels.ingredients')
        );

        $this->addColumns();
        $this->addDefaultSorting();
        $this->addFields();
    }

    /**
     * @param IngredientStoreCrudRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(IngredientStoreCrudRequest $request)
    {
        return parent::storeCrud();
    }

    /**
     * @param IngredientUpdateCrudRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(IngredientUpdateCrudRequest $request)
    {
        return parent::updateCrud();
    }

    /**
     * Set CRUD filters
     */
    protected function setFilters()
    {
        $this->addFilter([
            'name' => 'title',
            'label' => trans('crud.labels.title')
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
            'name' => 'title',
            'label' => $this->getRequiredLabel(trans('crud.labels.title')),
        ]);
    }
}
