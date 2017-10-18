<?php

namespace App\Http\Controllers\Backend;

use App\Http\Requests\Backend\TagStoreCrudRequest;
use App\Http\Requests\Backend\TagUpdateCrudRequest;

/**
 * Class TagCrud
 * @package App\Http\Controllers\Backend
 */
class TagCrud extends AbstractCrud
{
    /**
     * @var string
     */
    protected $model = 'App\Models\Tag';

    /**
     * Setup CRUD.
     */
    public function setup()
    {
        parent::setup();

        $this->crud->setRoute('admin/tags');
        $this->crud->setEntityNameStrings(
            trans('crud.labels.tag'),
            trans('crud.labels.tags')
        );

        $this->addColumns();
        $this->addDefaultSorting();
        $this->addFields();
    }

    /**
     * @param TagStoreCrudRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(TagStoreCrudRequest $request)
    {
        return parent::storeCrud();
    }

    /**
     * @param TagUpdateCrudRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(TagUpdateCrudRequest $request)
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
