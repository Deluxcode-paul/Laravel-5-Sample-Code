<?php

namespace App\Http\Controllers\Backend;

use App\Enums\UserRole;
use App\Http\Requests\Backend\UserCrudStoreRequest;
use App\Http\Requests\Backend\UserCrudUpdateRequest;

/**
 * Class UserCrud
 * @package App\Http\Controllers\Backend
 */
class TopChefCrud extends AbstractCrud
{
    /**
     * @var string
     */
    protected $model = 'App\Models\TopChef';

    /**
     * @var bool
     */
    protected $hasPasswordField = true;

    /**
     * Setup CRUD.
     */
    public function setup()
    {
        parent::setup();

        $this->crud->setRoute('admin/top-chefs');
        $this->crud->setEntityNameStrings(
            trans('crud.labels.top_chef'),
            trans('crud.labels.top_chefs')
        );

        $this->addColumns();
        $this->addDefaultSorting();
        $this->addFields();
        $this->crud->addButtonFromView('line', 'bfm_preview', 'bfm_preview', 'end');
    }

    /**
     * @param UserCrudStoreRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(UserCrudStoreRequest $request)
    {
        return parent::storeCrud($request->processImages()->processPassword()->processRole());
    }

    /**
     * @param UserCrudUpdateRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(UserCrudUpdateRequest $request)
    {
        return parent::updateCrud($request->processImages()->processPassword()->processRole());
    }

    /**
     * Set CRUD filters
     */
    protected function setFilters()
    {
        $this->addFilter([
            'name' => 'first_name',
            'label' => trans('crud.labels.first_name')
        ]);
        $this->addFilter([
            'name' => 'last_name',
            'label' => trans('crud.labels.last_name')
        ]);
        $this->addFilter([
            'name' => 'name',
            'label' => trans('crud.labels.name')
        ]);
        $this->addFilter([
            'name' => 'email',
            'label' => trans('crud.labels.email')
        ]);
        $this->addFilter([
            'type' => 'select2',
            'name' => 'is_featured',
            'label' => trans('crud.labels.is_featured'),
            'size' => 'col-md-1'
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
            'name' => 'first_name',
            'label' => trans('crud.labels.first_name'),
        ]);
        $this->crud->addColumn([
            'name' => 'last_name',
            'label' => trans('crud.labels.last_name'),
        ]);
        $this->crud->addColumn([
            'name' => 'name',
            'label' => trans('crud.labels.name'),
        ]);
        $this->crud->addColumn([
            'name' => 'email',
            'label' => trans('crud.labels.email'),
        ]);
        $this->crud->addColumn([
            'type' => 'bfm_checkbox',
            'name' => 'is_featured',
            'label' => trans('crud.labels.is_featured'),
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
        $this->addCommonFields();
        $this->addLocationFields();
        $this->addSocialFields();

        $this->crud->addField([
            'type' => 'checkbox',
            'name' => 'is_featured',
            'label' => trans('crud.labels.is_featured'),
        ]);
    }

    private function addCommonFields()
    {
        $this->crud->addField([
            'type' => 'hidden',
            'name' => 'roles',
            'value' => UserRole::ROLE_PROFESSIONAL_CHEF,
            'entity' => 'roles',
            'attribute' => 'name',
            'model' => config('laravel-permission.models.role'),
            'pivot' => true
        ]);
        $this->crud->addField([
            'name' => 'name',
            'label' => $this->getRequiredLabel(trans('crud.labels.name')),
        ], 'create');
        $this->crud->addField([
            'name' => 'name',
            'label' => trans('crud.labels.name'),
            'attributes' => [
                'disabled' => 'disabled'
            ]
        ], 'update');
        $this->crud->addField([
            'name' => 'email',
            'label' => $this->getRequiredLabel(trans('crud.labels.email')),
        ], 'create');
        $this->crud->addField([
            'name' => 'email',
            'label' => trans('crud.labels.email'),
            'attributes' => [
                'disabled' => 'disabled'
            ]
        ], 'update');
        $this->crud->addField([
            'type' => 'password',
            'name' => 'password',
            'label' => $this->getRequiredLabel(trans('crud.labels.password')),
            'attributes' => [
                'autocomplete' => 'new-password'
            ]
        ], 'create');
        $this->crud->addField([
            'type' => 'password',
            'name' => 'password',
            'label' => trans('crud.labels.password'),
            'attributes' => [
                'autocomplete' => 'new-password'
            ]
        ], 'update');
        $this->crud->addField([
            'name' => 'first_name',
            'label' => $this->getRequiredLabel(trans('crud.labels.first_name')),
        ]);
        $this->crud->addField([
            'name' => 'last_name',
            'label' => trans('crud.labels.last_name'),
        ]);
        $this->crud->addField([
            'type' => 'browse',
            'name' => 'image',
            'label' => trans('crud.labels.image'),
            'hint' => $this->getImageHint('1920 x 1200px')
        ]);
        $this->crud->addField([
            'type' => 'textarea',
            'name' => 'bio',
            'label' => trans('crud.labels.bio'),
        ]);
        $this->crud->addField([
            'name' => 'status',
            'label' => trans('crud.labels.status'),
            'attributes' => [
                'maxlength' => 140
            ]
        ]);
    }

    private function addLocationFields()
    {
        $this->crud->addField([
            'type' => 'select2',
            'name' => 'country_id',
            'label' => trans('crud.labels.country'),
            'entity' => 'country',
            'attribute' => 'title',
            'model' => 'App\Models\Country',
            'attributes' => [
                'placeholder' => trans('crud.placeholders.select_country')
            ]
        ]);
        $this->crud->addField([
            'type' => 'select2',
            'name' => 'state_id',
            'label' => trans('crud.labels.state'),
            'entity' => 'state',
            'attribute' => 'title',
            'model' => 'App\Models\State',
            'attributes' => [
                'placeholder' => trans('crud.placeholders.select_state')
            ]
        ]);
        $this->crud->addField([
            'name' => 'city',
            'label' => trans('crud.labels.city'),
        ]);
        $this->crud->addField([
            'name' => 'place_of_work',
            'label' => trans('crud.labels.place_of_work'),
        ]);
    }

    private function addSocialFields()
    {
        $this->crud->addField([
            'name' => 'facebook',
            'label' => trans('crud.labels.facebook'),
        ]);
        $this->crud->addField([
            'name' => 'instagram',
            'label' => trans('crud.labels.instagram'),
        ]);
        $this->crud->addField([
            'name' => 'pinterest',
            'label' => trans('crud.labels.pinterest'),
        ]);
        $this->crud->addField([
            'name' => 'twitter',
            'label' => trans('crud.labels.twitter'),
        ]);
        $this->crud->addField([
            'name' => 'youtube',
            'label' => trans('crud.labels.youtube'),
        ]);
        $this->crud->addField([
            'name' => 'website',
            'label' => trans('crud.labels.website'),
        ]);
    }
}
