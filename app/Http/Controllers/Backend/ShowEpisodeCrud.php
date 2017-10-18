<?php

namespace App\Http\Controllers\Backend;

use App\Facades\KosherHelper;
use App\Http\Requests\Backend\ShowEpisodeCrudRequest;
use App\Models\Show;

/**
 * Class ShowEpisodeCrud
 * @package App\Http\Controllers\Backend
 */
class ShowEpisodeCrud extends AbstractCrud
{
    /**
     * @var string
     */
    protected $model = 'App\Models\Video';

    /**
     * @var mixed
     */
    protected $owner;

    /**
     * Setup CRUD.
     */
    public function setup()
    {
        parent::setup();

        $this->setOwnerId();
        $this->checkOwnerExistence();
        $this->setShowId();
        $this->setOwnerType('App\Models\Show');

        $this->crud->setRoute('admin/shows/' . $this->getOwnerId() . '/episodes');
        $this->crud->addClause('where', 'owner_id', '=', $this->getOwnerId());
        $this->crud->addClause('where', 'owner_type', '=', $this->getOwnerType());
        $this->crud->setEntityNameStrings(
            trans('crud.labels.show_episode'),
            trans('crud.labels.show_episodes')
        );

        $this->addColumns();
        $this->addDefaultSorting();
        $this->addFields();
        $this->addFormButtons();
        $this->addBreadcrumbs();
        $this->crud->addButtonFromView('line', 'bfm_preview', 'bfm_preview', 'end');
    }

    /**
     * @param ShowEpisodeCrudRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(ShowEpisodeCrudRequest $request)
    {
        return parent::storeCrud($request->processImages()->processVideos()->processTags());
    }

    /**
     * @param ShowEpisodeCrudRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(ShowEpisodeCrudRequest $request)
    {
        return parent::updateCrud($request->processImages()->processVideos()->processTags());
    }

    /**
     * Set recipe ID
     */
    private function setShowId()
    {
        $this->data['showId'] = $this->getOwnerId();
    }

    /**
     * Check if owner exists
     */
    private function checkOwnerExistence()
    {
        $this->owner = Show::find($this->getOwnerId());
        if (empty($this->owner)) {
            abort(404);
        }
    }

    /**
     * Add form buttons
     */
    private function addFormButtons()
    {
        $this->crud->addButtonFromView('form', 'bfm_save_and_new', 'form.bfm_save_and_new');
        $this->crud->addButtonFromView('form', 'bfm_save', 'form.bfm_save');
        $this->crud->addButtonFromView('form', 'bfm_cancel', 'form.bfm_cancel');
    }

    /**
     * Add breadcrumbs
     */
    private function addBreadcrumbs()
    {
        $this->data['breadcrumbs'][] = [
            'url' => url('admin/shows'),
            'title' => trans('crud.labels.shows')
        ];
        $title = KosherHelper::trimForBreadcrumbs($this->owner->title);
        $this->setHeading($title);
        $this->data['breadcrumbs'][] = [
            'url' => url('admin/shows/' . $this->owner->id . '/edit'),
            'title' => $title
        ];
    }

    /**
     * Add CRUD columns
     *
     * @return void
     */
    private function addColumns()
    {
        $this->crud->addColumn([
            'name' => 'episode',
            'label' => trans('crud.labels.episode')
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
            'label' => trans('crud.labels.title')
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
            'type' => 'number',
            'name' => 'episode',
            'label' => trans('crud.labels.episode'),
            'attributes' => [
                'min' => 1
            ]
        ]);
        $this->crud->addField([
            'type' => 'browse',
            'name' => 'image',
            'label' => trans('crud.labels.cover'),
            'hint' => $this->getImageHint('1920 x 1200px')
        ]);
        $this->crud->addField([
            'name' => 'title',
            'label' => trans('crud.labels.title'),
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
