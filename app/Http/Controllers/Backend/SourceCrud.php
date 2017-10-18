<?php

namespace App\Http\Controllers\Backend;

use App\Http\Requests\Backend\SourceCrudRequest;

/**
 * Class SourceCrud
 * @package App\Http\Controllers\Backend
 */
class SourceCrud extends AbstractCrud
{
    /**
     * @var string
     */
    protected $model = 'App\Models\Source';

    /**
     * Setup CRUD.
     */
    public function setup()
    {
        parent::setup();

        $this->crud->setRoute('admin/sources');
        $this->crud->setEntityNameStrings(
            trans('crud.labels.source'),
            trans('crud.labels.sources')
        );

        $this->addColumns();
        $this->addDefaultSorting();
        $this->addFields();
    }

    /**
     * @param SourceCrudRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(SourceCrudRequest $request)
    {
        return parent::storeCrud();
    }

    /**
     * @param SourceCrudRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(SourceCrudRequest $request)
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
