<?php

namespace App\Http\Controllers\Backend;

use App\Http\Requests\Backend\CuisineCrudRequest;
use App\Models\Preference;

/**
 * Class CuisineCrud
 * @package App\Http\Controllers\Backend
 */
class CuisineCrud extends AbstractCrud
{
    /**
     * @var string
     */
    protected $model = 'App\Models\Cuisine';

    /**
     * Setup CRUD.
     */
    public function setup()
    {
        parent::setup();

        $this->crud->setRoute('admin/cuisines');
        $this->crud->setEntityNameStrings(
            trans('crud.labels.cuisine'),
            trans('crud.labels.cuisines')
        );

        $this->addColumns();
        $this->addDefaultSorting();
        $this->addFields();
    }

    /**
     * @param CuisineCrudRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(CuisineCrudRequest $request)
    {
        return parent::storeCrud();
    }

    /**
     * @param CuisineCrudRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(CuisineCrudRequest $request)
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
            'label' => $this->getRequiredLabel(trans('crud.labels.title')),
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
