<?php

namespace App\Http\Controllers\Backend;

use App\Http\Requests\Backend\CallToActionCrudRequest;

/**
 * Class CallToActionCrud
 * @package App\Http\Controllers\Backend
 */
class CallToActionCrud extends AbstractCrud
{
    /**
     * @var string
     */
    protected $model = 'App\Models\CallToAction';

    /**
     * Setup CRUD.
     */
    public function setup()
    {
        parent::setup();

        $this->crud->setRoute('admin/call-to-actions');
        $this->crud->setEntityNameStrings(
            trans('crud.labels.call_to_action'),
            trans('crud.labels.call_to_actions')
        );

        if (config('kosher.cta_limit') <= $this->crud->getEntries()->count()) {
            $this->crud->denyAccess('create');
        }

        $this->addColumns();
        $this->addDefaultSorting();
        $this->addFields();
    }

    /**
     * @param CallToActionCrudRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(CallToActionCrudRequest $request)
    {
        return parent::storeCrud($request->processImages());
    }

    /**
     * @param CallToActionCrudRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(CallToActionCrudRequest $request)
    {
        return parent::updateCrud($request->processImages());
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
            'name' => 'link',
            'label' => trans('crud.labels.link'),
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
            'type' => 'textarea',
            'name' => 'description',
            'label' => $this->getRequiredLabel(trans('crud.labels.description')),
        ]);
        $this->crud->addField([
            'name' => 'link',
            'label' => $this->getRequiredLabel(trans('crud.labels.link')),
        ]);
        $this->crud->addField([
            'name' => 'button_text',
            'label' => $this->getRequiredLabel(trans('crud.labels.button_text')),
        ]);
        $this->crud->addField([
            'type' => 'browse',
            'name' => 'image',
            'label' => $this->getRequiredLabel(trans('crud.labels.image')),
            'hint' => $this->getImageHint('385 x 390px')
        ]);
    }
}
