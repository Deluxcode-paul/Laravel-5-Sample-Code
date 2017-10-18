<?php

namespace App\Http\Controllers\Backend;

use App\Http\Requests\Backend\PageCrudRequest;

/**
 * Class PageCrud
 * @package App\Http\Controllers\Backend
 */
class PageCrud extends AbstractCrud
{
    /**
     * @var string
     */
    protected $model = 'App\Models\Page';

    /**
     * Setup CRUD.
     */
    public function setup()
    {
        parent::setup();

        $this->crud->setRoute('admin/cms');
        $this->crud->setEntityNameStrings(
            trans('crud.labels.cms_page'),
            trans('crud.labels.cms_pages')
        );

        $this->addColumns();
        $this->addDefaultSorting();
        $this->addFields();
        $this->crud->removeButton('delete');
        $this->crud->addButtonFromView('top', 'bfm_pages_tree', 'bfm_pages_tree', 'end');
        $this->crud->addButtonFromView('line', 'delete_page', 'delete_page', 'end');
        $this->crud->addButtonFromView('line', 'bfm_preview', 'bfm_preview', 'end');
        $this->crud->addButtonFromView('line', 'bfm_cms_constructor', 'bfm_cms_constructor', 'end');
    }

    /**
     * @param PageCrudRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(PageCrudRequest $request)
    {
        return parent::storeCrud($request->processImages());
    }

    /**
     * @param PageCrudRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(PageCrudRequest $request)
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
            'name' => 'enabled',
            'label' => trans('crud.labels.enabled'),
            'size' => 'col-md-1'
        ]);
        $this->addFilter([
            'type' => 'date_range',
            'name' => 'updated_at',
            'label' => trans('crud.labels.updated_at')
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
            'label' => trans('crud.labels.title')
        ]);
        $this->crud->addColumn([
            'type' => 'bfm_image',
            'name' => 'image',
            'label' => trans('crud.labels.cover'),
            'attributes' => [
                'data-orderable' => false
            ]
        ]);
        $this->crud->addColumn([
            'type' => 'bfm_checkbox',
            'name' => 'enabled',
            'label' => trans('crud.labels.enabled'),
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
        $pageLayouts = array_keys(config('cms-pages.pageLayouts'));
        $this->crud->addField([
            'type' => 'hidden',
            'name' => 'layout',
            'value' => reset($pageLayouts)
        ]);
        $this->crud->addField([
            'name' => 'title',
            'label' => $this->getRequiredLabel(trans('crud.labels.title')),
        ]);
        $this->crud->addField([
            'name' => 'headline',
            'label' => trans('crud.labels.headline'),
        ]);
        $this->crud->addField([
            'type' => 'browse',
            'name' => 'image',
            'label' => $this->getRequiredLabel(trans('crud.labels.background_image')),
            'hint' => $this->getImageHint('1920 x 1200px')
        ]);
        $this->crud->addField([
            'name' => 'keywords',
            'label' => trans('crud.labels.keywords'),
        ]);
        $this->crud->addField([
            'name' => 'description',
            'label' => trans('crud.labels.description'),
        ]);
        $this->crud->addField([
            'name' => 'alias',
            'label' => $this->getRequiredLabel(trans('crud.labels.alias')),
            'hint' => 'Only letters, numbers, dashes. No spaces.'
        ]);
        $this->crud->addField([
            'type' => 'checkbox',
            'name' => 'enabled',
            'label' => trans('crud.labels.enabled'),
        ]);
    }
}
