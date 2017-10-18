<?php

namespace App\Http\Controllers\Backend;

use App\Http\Requests\Backend\ShowCrudRequest;
use App\Models\Chef;

/**
 * Class ShowCrud
 * @package App\Http\Controllers\Backend
 */
class ShowCrud extends AbstractCrud
{
    /**
     * @var string
     */
    protected $model = 'App\Models\Show';

    /**
     * Setup CRUD.
     */
    public function setup()
    {
        parent::setup();

        $this->crud->setRoute('admin/shows');
        $this->crud->setEntityNameStrings(
            trans('crud.labels.show'),
            trans('crud.labels.shows')
        );

        $this->addLineButtons();
        $this->addColumns();
        $this->addDefaultSorting();
        $this->addFields();
        $this->addFormButtons();
    }

    /**
     * @param ShowCrudRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(ShowCrudRequest $request)
    {
        return parent::storeCrud($request->processImages());
    }

    /**
     * @param ShowCrudRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(ShowCrudRequest $request)
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
            'name' => 'chefs',
            'relation' => 'chefs',
            'attribute' => 'chef_id',
            'label' => trans('crud.labels.chefs'),
            'options' => Chef::all()->sortBy('fullName')->pluck('fullName', 'id'),
            'placeholder' => trans('crud.placeholders.any')
        ]);
        $this->addFilter([
            'type' => 'select2',
            'name' => 'is_featured',
            'label' => trans('crud.labels.is_featured'),
            'size' => 'col-md-1'
        ]);
        $this->addFilter([
            'type' => 'select2',
            'name' => 'is_banner',
            'label' => trans('crud.labels.is_banner'),
            'size' => 'col-md-1'
        ]);
    }

    /**
     * Add form buttons
     */
    private function addFormButtons()
    {
        $this->addFormHeaderButtons();
        $this->crud->addButtonFromView('form', 'bfm_save_and_publish', 'form.bfm_save_and_publish');
        $this->crud->addButtonFromView('form', 'bfm_cancel', 'form.bfm_cancel');
    }

    /**
     * Add form header buttons
     */
    private function addFormHeaderButtons()
    {
        $this->crud->addButtonFromView('form_header', 'bfm_show_episodes', 'bfm_show_episodes');
        $this->crud->addButtonFromView('form_header', 'bfm_preview', 'bfm_preview');
    }

    /**
     * Add buttons
     */
    private function addLineButtons()
    {
        $this->crud->addButtonFromView('line', 'bfm_preview', 'bfm_preview', 'end');
        $this->crud->addButtonFromView('relation_line', 'bfm_show_episodes', 'bfm_show_episodes');
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
            'name' => 'logo',
            'label' => trans('crud.labels.logo'),
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
            'name' => 'is_banner',
            'label' => trans('crud.labels.is_banner'),
        ]);
        $this->crud->addColumn([
            'type' => 'datetime',
            'name' => 'updated_at',
            'label' => trans('crud.labels.updated_at'),
        ]);
        $this->crud->addColumn([
            'type' => 'select_multiple',
            'name' => 'chefs',
            'label' => trans('crud.labels.chefs'),
            'entity' => 'chefs',
            'attribute' => 'fullName',
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
            'type' => 'browse',
            'name' => 'logo',
            'label' => $this->getRequiredLabel(trans('crud.labels.logo')),
            'hint' => $this->getImageHint('240 x 240px')
        ]);
        $this->crud->addField([
            'type' => 'browse',
            'name' => 'cover',
            'label' => $this->getRequiredLabel(trans('crud.labels.cover')),
            'hint' => $this->getImageHint('450 x 450px')
        ]);
        $this->crud->addField([
            'type' => 'browse',
            'name' => 'banner',
            'label' => $this->getRequiredLabel(trans('crud.labels.banner')),
            'hint' => $this->getImageHint('1920 x 1200px')
        ]);
        $this->crud->addField([
            'type' => 'textarea',
            'name' => 'description',
            'label' => $this->getRequiredLabel(trans('crud.labels.description')),
            'attributes' => [
                'maxlength' => 360
            ]
        ]);
        $this->crud->addField([
            'type' => 'checkbox',
            'name' => 'is_featured',
            'label' => trans('crud.labels.is_featured'),
        ]);
        $this->crud->addField([
            'type' => 'checkbox',
            'name' => 'is_banner',
            'label' => trans('crud.labels.is_banner'),
        ]);
        $this->crud->addField([
            'type' => 'select2_multiple',
            'name' => 'chefs',
            'label' => trans('crud.labels.chefs'),
            'entity' => 'chefs',
            'attribute' => 'fullName',
            'model' => 'App\Models\Chef',
            'pivot' => true,
            'attributes' => [
                'placeholder' => trans('crud.placeholders.select_chefs')
            ]
        ]);
    }
}
