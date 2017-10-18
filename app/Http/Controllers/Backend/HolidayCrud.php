<?php

namespace App\Http\Controllers\Backend;

use App\Http\Requests\Backend\HolidayCrudRequest;
use App\Models\Preference;

/**
 * Class HolidayCrud
 * @package App\Http\Controllers\Backend
 */
class HolidayCrud extends AbstractCrud
{
    /**
     * @var string
     */
    protected $model = 'App\Models\Holiday';

    /**
     * Setup CRUD.
     */
    public function setup()
    {
        parent::setup();

        $this->crud->setRoute('admin/holidays');
        $this->crud->setEntityNameStrings(
            trans('crud.labels.holiday'),
            trans('crud.labels.holidays')
        );

        $this->addColumns();
        $this->addDefaultSorting();
        $this->addFields();
    }

    /**
     * @param HolidayCrudRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(HolidayCrudRequest $request)
    {
        return parent::storeCrud($request->processImages()->processDates());
    }

    /**
     * @param HolidayCrudRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(HolidayCrudRequest $request)
    {
        return parent::updateCrud($request->processImages()->processDates());
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
        $this->addFilter([
            'type' => 'date_range',
            'name' => 'starts_at',
            'label' => trans('crud.labels.starts_at')
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
            'name' => 'starts_at',
            'label' => trans('crud.labels.starts_at'),
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
            'type' => 'browse',
            'name' => 'image',
            'label' => $this->getRequiredLabel(trans('crud.labels.image')),
            'hint' => $this->getImageHint('265 x 265px')
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
        $this->crud->addField([
            'type' => 'date_picker',
            'name' => 'starts_at',
            'label' => trans('crud.labels.starts_at'),
        ]);
    }
}
