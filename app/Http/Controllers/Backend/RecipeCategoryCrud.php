<?php

namespace App\Http\Controllers\Backend;

use App\Http\Requests\Backend\RecipeCategoryCrudRequest;

/**
 * Class RecipeCategoryCrud
 * @package App\Http\Controllers\Backend
 */
class RecipeCategoryCrud extends AbstractCrud
{
    /**
     * @var string
     */
    protected $model = 'App\Models\RecipeCategory';

    /**
     * Setup CRUD.
     */
    public function setup()
    {
        parent::setup();

        $this->crud->setRoute('admin/recipe-categories');
        $this->crud->setEntityNameStrings(
            trans('crud.labels.recipe_category'),
            trans('crud.labels.recipe_categories')
        );

        $this->addColumns();
        $this->addDefaultSorting();
        $this->addFields();
    }

    /**
     * @param RecipeCategoryCrudRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(RecipeCategoryCrudRequest $request)
    {
        return parent::storeCrud($request->processImages());
    }

    /**
     * @param RecipeCategoryCrudRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(RecipeCategoryCrudRequest $request)
    {
        return parent::updateCrud($request->processImages());
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
        $this->addFilter([
            'type' => 'select2',
            'name' => 'is_featured',
            'label' => trans('crud.labels.is_featured'),
            'size' => 'col-md-1'
        ]);
        $this->addFilter([
            'type' => 'select2',
            'name' => 'is_megamenu',
            'label' => trans('crud.labels.is_megamenu'),
            'size' => 'col-md-1'
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
            'type' => 'bfm_image',
            'name' => 'image',
            'label' => trans('crud.labels.image'),
            'attributes' => [
                'data-orderable' => false
            ]
        ]);
        $this->crud->addColumn([
            'type' => 'bfm_checkbox',
            'name' => 'is_featured',
            'label' => trans('crud.labels.is_featured'),
        ]);
        $this->crud->addColumn([
            'type' => 'bfm_checkbox',
            'name' => 'is_megamenu',
            'label' => trans('crud.labels.is_megamenu'),
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
        $this->crud->addField([
            'type' => 'browse',
            'name' => 'image',
            'label' => $this->getRequiredLabel(trans('crud.labels.image')),
            'hint' => $this->getImageHint('265 x 265px')
        ]);
        $this->crud->addField([
            'type' => 'checkbox',
            'name' => 'is_featured',
            'label' => trans('crud.labels.is_featured'),
        ]);
        $this->crud->addField([
            'type' => 'checkbox',
            'name' => 'is_megamenu',
            'label' => trans('crud.labels.is_megamenu'),
        ]);
    }
}
