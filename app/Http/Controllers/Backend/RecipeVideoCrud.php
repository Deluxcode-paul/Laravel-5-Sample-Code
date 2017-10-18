<?php

namespace App\Http\Controllers\Backend;

use App\Http\Requests\Backend\RecipeVideoCrudRequest;

/**
 * Class RecipeVideoCrud
 * @package App\Http\Controllers\Backend
 */
class RecipeVideoCrud extends AbstractRecipeRelationCrud
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

        $this->setOwnerAttributeName('');
        $this->setOwnerType('App\Models\Recipe');

        $this->crud->setRoute('admin/recipes/' . $this->getOwnerId() . '/videos');
        $this->crud->addClause('where', 'owner_id', '=', $this->getOwnerId());
        $this->crud->addClause('where', 'owner_type', '=', $this->getOwnerType());
        $this->crud->setEntityNameStrings(
            trans('crud.labels.recipe_video'),
            trans('crud.labels.recipe_videos')
        );

        $this->addColumns();
        $this->addDefaultSorting();
        $this->addFields();
        $this->addFormButtons();
        $this->addRelationButtons();
        $this->crud->addButtonFromView('line', 'bfm_preview', 'bfm_preview', 'end');
        $this->addBreadcrumbs();
    }

    /**
     * @param RecipeVideoCrudRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(RecipeVideoCrudRequest $request)
    {
        return parent::storeCrud($request->processImages()->processVideos()->processTags());
    }

    /**
     * @param RecipeVideoCrudRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(RecipeVideoCrudRequest $request)
    {
        return parent::updateCrud($request->processImages()->processVideos()->processTags());
    }

    /**
     * Add CRUD columns
     *
     * @return void
     */
    private function addColumns()
    {
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
