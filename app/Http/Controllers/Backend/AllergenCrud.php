<?php

namespace App\Http\Controllers\Backend;

use App\Http\Requests\Backend\AllergenCrudRequest;
use App\Models\Preference;

/**
 * Class AllergenCrud
 * @package App\Http\Controllers\Backend
 */
class AllergenCrud extends AbstractCrud
{
    /**
     * @var string
     */
    protected $model = 'App\Models\Allergen';

    /**
     * Setup CRUD.
     */
    public function setup()
    {
        parent::setup();

        $this->crud->setRoute('admin/allergens');
        $this->crud->setEntityNameStrings(
            trans('crud.labels.allergen'),
            trans('crud.labels.allergens')
        );
        $this->crud->denyAccess('create');
        $this->crud->denyAccess('delete');

        $this->addColumns();
        $this->addDefaultSorting();
        $this->addFields();
    }

    /**
     * @param AllergenCrudRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(AllergenCrudRequest $request)
    {
        return parent::storeCrud();
    }

    /**
     * @param AllergenCrudRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(AllergenCrudRequest $request)
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
        $this->addFilter([
            'type' => 'select2',
            'name' => 'preferences',
            'relation' => 'preferences',
            'attribute' => 'preference_id',
            'label' => trans('crud.labels.preferences'),
            'options' => Preference::all()->sortBy('title')->pluck('title', 'id'),
            'placeholder' => trans('crud.placeholders.any')
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
        $this->crud->addColumn([
            'type' => 'select_multiple',
            'name' => 'preferences',
            'label' => trans('crud.labels.preferences'),
            'entity' => 'preferences',
            'attribute' => 'title',
            'attributes' => [
                'data-orderable' => false
            ]
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
            'label' => trans('crud.labels.title'),
            'attributes' => [
                'disabled' => 'disabled'
            ]
        ]);
        $this->crud->addField([
            'type' => 'select2_multiple',
            'name' => 'preferences',
            'label' => trans('crud.labels.preferences'),
            'entity' => 'preferences',
            'attribute' => 'title',
            'model' => 'App\Models\Preference',
            'pivot' => true,
        ]);
    }
}
