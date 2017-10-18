<?php

namespace App\Http\Controllers\Backend;

use App\Facades\KosherHelper;
use App\Http\Requests\Backend\GeneralAnswerCrudRequest;
use App\Models\GeneralQuestion;
use App\Models\User;

/**
 * Class GeneralAnswerCrud
 * @package App\Http\Controllers\Backend
 */
class GeneralAnswerCrud extends AbstractCrud
{
    /**
     * @var string
     */
    protected $model = 'App\Models\GeneralAnswer';

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
        $this->setOwnerAttributeName('question_id');
        $this->checkOwnerExistence();

        $this->crud->setRoute('admin/community-questions/' . $this->getOwnerId() . '/answers');
        $this->crud->setEntityNameStrings(
            trans('crud.labels.general_answer'),
            trans('crud.labels.general_answers')
        );

        $this->addColumns();
        $this->addDefaultSorting();
        $this->addFields();
        $this->addFormButtons();
        $this->addBreadcrumbs();
    }

    /**
     * @param GeneralAnswerCrudRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(GeneralAnswerCrudRequest $request)
    {
        return parent::storeCrud($request->processTags());
    }

    /**
     * @param GeneralAnswerCrudRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(GeneralAnswerCrudRequest $request)
    {
        return parent::updateCrud($request->processTags());
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
            'options' => User::all()->sortBy('fullName')->pluck('fullName', 'id'),
            'placeholder' => trans('crud.placeholders.any')
        ]);
        $this->addFilter([
            'name' => 'details',
            'label' => trans('crud.labels.details')
        ]);
        $this->addFilter([
            'type' => 'date_range',
            'name' => 'created_at',
            'label' => trans('crud.labels.created_at')
        ]);
        $this->addFilter([
            'type' => 'date_range',
            'name' => 'updated_at',
            'label' => trans('crud.labels.updated_at')
        ]);
    }

    /**
     * Check if owner exists
     */
    private function checkOwnerExistence()
    {
        $this->owner = GeneralQuestion::find($this->getOwnerId());
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
            'url' => url('admin/community-questions'),
            'title' => trans('crud.labels.general_questions')
        ];
        $title = KosherHelper::trimForBreadcrumbs($this->owner->title);
        $this->setHeading($title);
        $this->data['breadcrumbs'][] = [
            'url' => url('admin/community-questions/' . $this->owner->id . '/edit'),
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
            'type' => 'bfm_user_link',
            'name' => 'user_id',
            'label' => trans('crud.labels.author'),
            'entity' => 'user',
            'attribute' => 'fullName',
        ]);
        $this->crud->addColumn([
            'name' => 'details',
            'label' => trans('crud.labels.details'),
        ]);
        $this->crud->addColumn([
            'name' => 'reports',
            'label' => trans('crud.labels.reports'),
        ]);
        $this->crud->addColumn([
            'name' => 'votes',
            'label' => trans('crud.labels.votes'),
        ]);
        $this->crud->addColumn([
            'type' => 'datetime',
            'name' => 'created_at',
            'label' => trans('crud.labels.created_at'),
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
            'name' => 'question_id',
            'value' => $this->getOwnerId()
        ]);
        $this->crud->addField([
            'type' => 'select2',
            'name' => 'user_id',
            'label' => $this->getRequiredLabel(trans('crud.labels.author')),
            'entity' => 'user',
            'attribute' => 'fullName',
            'model' => 'App\Models\User',
            'attributes' => [
                'placeholder' => trans('crud.placeholders.select_author'),
                'required' => '1'
            ]
        ]);
        $this->crud->addField([
            'type' => 'textarea',
            'name' => 'details',
            'label' => $this->getRequiredLabel(trans('crud.labels.details')),
        ]);
    }
}
