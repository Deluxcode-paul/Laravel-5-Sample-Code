<?php

namespace App\Http\Controllers\Backend;

use App\Http\Requests\Backend\BlessingTypeCrudRequest;

/**
 * Class BlessingTypeCrud
 * @package App\Http\Controllers\Backend
 */
class BlessingTypeCrud extends AbstractCrud
{
    /**
     * @var string
     */
    protected $model = 'App\Models\BlessingType';

    /**
     * Setup CRUD.
     */
    public function setup()
    {
        parent::setup();

        $this->crud->setRoute('admin/blessing-types');
        $this->crud->setEntityNameStrings(
            trans('crud.labels.blessing_type'),
            trans('crud.labels.blessing_types')
        );

        $this->addColumns();
        $this->addDefaultSorting();
        $this->addFields();
    }

    /**
     * @param BlessingTypeCrudRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(BlessingTypeCrudRequest $request)
    {
        return parent::storeCrud();
    }

    /**
     * @param BlessingTypeCrudRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(BlessingTypeCrudRequest $request)
    {
        return parent::updateCrud();
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
