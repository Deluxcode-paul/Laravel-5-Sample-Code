<?php

namespace App\Http\Controllers\Backend;

use App\Http\Requests\Backend\VideoCrudRequest;
use App\Models\Chef;

/**
 * Class VideoCrud
 * @package App\Http\Controllers\Backend
 */
class VideoCrud extends AbstractCrud
{
    /**
     * @var string
     */
    protected $model = 'App\Models\Video';

    /**
     * Setup CRUD.
     */
    public function setup()
    {
        parent::setup();

        $this->crud->setRoute('admin/videos');
        $this->crud->setEntityNameStrings(
            trans('crud.labels.video'),
            trans('crud.labels.videos')
        );

        $this->crud->denyAccess('create');

        $this->addColumns();
        $this->addDefaultSorting();
        $this->addFields();
        $this->crud->addButtonFromView('line', 'bfm_preview', 'bfm_preview', 'end');
    }

    /**
     * @param VideoCrudRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(VideoCrudRequest $request)
    {
        return parent::storeCrud($request->processImages()->processVideos()->processTags());
    }

    /**
     * @param VideoCrudRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(VideoCrudRequest $request)
    {
        return parent::updateCrud($request->processImages()->processVideos()->processTags());
    }

    /**
     * Set CRUD filters
     */
    protected function setFilters()
    {
        $this->addFilter([
            'type' => 'select2',
            'name' => 'user_id',
            'label' => trans('crud.labels.author'),
            'options' => Chef::all()->sortBy('fullName')->pluck('fullName', 'id'),
            'placeholder' => trans('crud.placeholders.any')
        ]);
        $this->addFilter([
            'name' => 'title',
            'label' => trans('crud.labels.title')
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
            'type' => 'bfm_user_link',
            'name' => 'user_id',
            'label' => trans('crud.labels.author'),
            'entity' => 'user',
            'attribute' => 'fullName',
            'attributes' => [
                'data-orderable' => false
            ]
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
            'name' => 'title',
            'label' => trans('crud.labels.title'),
        ]);
        $this->crud->addColumn([
            'type' => 'bfm_external_link',
            'name' => 'video',
            'label' => trans('crud.labels.video'),
            'attributes' => [
                'data-orderable' => false
            ]
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
            'type' => 'hidden',
            'name' => 'owner_id',
            'value' => $this->getOwnerId()
        ]);
        $this->crud->addField([
            'type' => 'hidden',
            'name' => 'owner_type',
            'value' => $this->getOwnerType()
        ]);
        $this->crud->addField([
            'type' => 'hidden',
            'name' => 'video_id'
        ]);
        $this->crud->addField([
            'type' => 'hidden',
            'name' => 'video_type'
        ]);
        $this->crud->addField([
            'type' => 'hidden',
            'name' => 'user_id'
        ]);
        $this->crud->addField([
            'name' => 'video',
            'label' => $this->getRequiredLabel(trans('crud.labels.video')),
            'hint' => trans('crud.hints.allowed_videos'),
        ]);
        $this->crud->addField([
            'name' => 'title',
            'label' => trans('crud.labels.title'),
        ]);
        $this->crud->addField([
            'type' => 'browse',
            'name' => 'image',
            'label' => trans('crud.labels.cover'),
            'hint' => $this->getImageHint('1920 x 1200px')
        ]);
        $this->crud->addField([
            'type' => 'textarea',
            'name' => 'description',
            'label' => trans('crud.labels.description'),
        ]);
        $this->crud->addField([
            'type' => 'number',
            'name' => 'episode',
            'label' => trans('crud.labels.episode'),
            'attributes' => [
                'min' => 1
            ]
        ]);
        $this->crud->addField([
            'type' => 'select2_tags',
            'name' => 'tags',
            'label' => trans('crud.labels.tags'),
            'entity' => 'tags',
            'attribute' => 'title',
            'model' => 'App\Models\Tag',
            'pivot' => true,
            'attributes' => [
                'placeholder' => trans('crud.placeholders.select_tags')
            ],
            'hint' => trans('crud.hints.select_or_create')
        ]);
    }
}
