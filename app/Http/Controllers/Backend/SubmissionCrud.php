<?php

namespace App\Http\Controllers\Backend;

use App\Enums\ContactInquiryTypes;
use App\Http\Requests\Backend\SubmissionCrudRequest;

/**
 * Class SubmissionCrud
 * @package App\Http\Controllers\Backend
 */
class SubmissionCrud extends AbstractCrud
{
    /**
     * @var string
     */
    protected $model = 'App\Models\Submission';

    /**
     * Setup CRUD.
     */
    public function setup()
    {
        parent::setup();

        $this->crud->setRoute('admin/contact-submissions');
        $this->crud->setEntityNameStrings(
            trans('crud.labels.contact_submission'),
            trans('crud.labels.contact_submissions')
        );

        $this->crud->denyAccess('create');

        $this->addColumns();
        $this->addDefaultSorting();
        $this->addFields();
    }

    /**
     * Set CRUD filters
     */
    protected function setFilters()
    {
        $this->addFilter([
            'type' => 'select2',
            'name' => 'inquiry_type',
            'label' => trans('crud.labels.inquiry_type'),
            'options' => ContactInquiryTypes::labels(),
            'placeholder' => trans('crud.placeholders.any')
        ]);
        $this->addFilter([
            'name' => 'name',
            'label' => trans('crud.labels.full_name')
        ]);
        $this->addFilter([
            'name' => 'email',
            'label' => trans('crud.labels.email')
        ]);
        $this->addFilter([
            'name' => 'ip_address',
            'label' => trans('crud.labels.ip_address')
        ]);
        $this->addFilter([
            'type' => 'date_range',
            'name' => 'updated_at',
            'label' => trans('crud.labels.updated_at')
        ]);
    }

    /**
     * @param SubmissionCrudRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(SubmissionCrudRequest $request)
    {
        return parent::storeCrud();
    }

    /**
     * @param SubmissionCrudRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(SubmissionCrudRequest $request)
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
            'type' => 'bfm_enum',
            'name' => 'inquiry_type',
            'label' => trans('crud.labels.inquiry_type'),
            'options' => ContactInquiryTypes::labels()
        ]);
        $this->crud->addColumn([
            'name' => 'name',
            'label' => trans('crud.labels.full_name')
        ]);
        $this->crud->addColumn([
            'name' => 'email',
            'label' => trans('crud.labels.email')
        ]);
        $this->crud->addColumn([
            'name' => 'ip_address',
            'label' => trans('crud.labels.ip_address'),
        ]);
        $this->crud->addColumn([
            'type' => 'bfm_user_link',
            'name' => 'user_id',
            'label' => trans('crud.labels.user'),
            'entity' => 'user',
            'attribute' => 'fullName',
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
            'name' => 'inquiry_type',
            'label' => trans('crud.labels.inquiry_type'),
            'attributes' => [
                'disabled' => 'disabled'
            ]
        ]);
        $this->crud->addField([
            'name' => 'name',
            'label' => trans('crud.labels.full_name'),
            'attributes' => [
                'disabled' => 'disabled'
            ]
        ]);
        $this->crud->addField([
            'name' => 'email',
            'label' => trans('crud.labels.email'),
            'attributes' => [
                'disabled' => 'disabled'
            ]
        ]);
        $this->crud->addField([
            'type' => 'textarea',
            'name' => 'message',
            'label' => trans('crud.labels.message'),
            'attributes' => [
                'disabled' => 'disabled'
            ]
        ]);
        $this->crud->addField([
            'name' => 'ip_address',
            'label' => trans('crud.labels.ip_address'),
            'attributes' => [
                'disabled' => 'disabled'
            ]
        ]);
    }
}
