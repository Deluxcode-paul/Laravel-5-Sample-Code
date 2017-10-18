<?php

namespace App\Http\Controllers\Backend;

use App\Enums\UserRole;
use App\Http\Requests\Backend\UserCrudStoreRequest;
use App\Http\Requests\Backend\UserCrudUpdateRequest;

/**
 * Class UserCrud
 * @package App\Http\Controllers\Backend
 */
class UserCrud extends AbstractCrud
{
    /**
     * @var string
     */
    protected $model = 'App\Models\User';

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

        $this->crud->setRoute('admin/users');
        $this->crud->setEntityNameStrings(
            trans('crud.labels.user'),
            trans('crud.labels.users')
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
        return parent::storeCrud($request->processImages()->processPassword());
    }

    /**
     * @param UserCrudUpdateRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(UserCrudUpdateRequest $request)
    {
        return parent::updateCrud($request->processImages()->processPassword());
    }

    /**
     * Set CRUD filters
     */
    protected function setFilters()
    {
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
            'name' => 'roles',
            'relation' => 'roles',
            'attribute' => 'role_id',
            'label' => trans('crud.labels.role'),
            'options' => UserRole::labels(),
            'placeholder' => trans('crud.placeholders.any')
        ]);
        $this->addFilter([
            'type' => 'select2',
            'name' => 'is_confirmed',
            'label' => trans('crud.labels.is_confirmed'),
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
            'name' => 'name',
            'label' => trans('crud.labels.name'),
        ]);
        $this->crud->addColumn([
            'name' => 'email',
            'label' => trans('crud.labels.email'),
        ]);
        $this->crud->addColumn([
            'type' => 'datetime',
            'name' => 'updated_at',
            'label' => trans('crud.labels.updated_at'),
        ]);
        $this->crud->addColumn([
            'label' => trans('crud.labels.role'),
            'type' => 'select_multiple',
            'name' => 'roles',
            'entity' => 'roles',
            'attribute' => 'name',
            'model' => config('laravel-permission.models.role'),
            'attributes' => [
                'data-orderable' => false
            ]
        ]);
        $this->crud->addColumn([
            'type' => 'bfm_checkbox',
            'name' => 'is_confirmed',
            'label' => trans('crud.labels.is_confirmed'),
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
            'type' => 'select2_multiple',
            'name' => 'roles',
            'label' => $this->getRequiredLabel(trans('crud.labels.role')),
            'entity' => 'roles',
            'attribute' => 'name',
            'model' => config('laravel-permission.models.role'),
            'pivot' => true,
            'attributes' => [
                'maximumSelectionSize' => 1,
                'placeholder' => trans('crud.placeholders.select_role')
            ]
        ]);
        $this->crud->addField([
            'type' => 'hidden',
            'name' => 'is_confirmed',
            'value' => 1,
        ], 'create');
        $this->crud->addField([
            'type' => 'checkbox',
            'name' => 'is_confirmed',
            'label' => trans('crud.labels.is_confirmed'),
        ], 'update');
    }
}
