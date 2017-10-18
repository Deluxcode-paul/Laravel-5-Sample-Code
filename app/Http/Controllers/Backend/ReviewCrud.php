<?php

namespace App\Http\Controllers\Backend;

use App\Http\Requests\Backend\ReviewCrudRequest;
use App\Models\User;

/**
 * Class ReviewCrud
 * @package App\Http\Controllers\Backend
 */
class ReviewCrud extends AbstractRecipeRelationCrud
{
    /**
     * @var string
     */
    protected $model = 'App\Models\Review';

    /**
     * Setup CRUD.
     */
    public function setup()
    {
        parent::setup();

        $this->crud->setRoute('admin/recipes/' . $this->getOwnerId() . '/reviews');
        $this->crud->addClause('where', 'recipe_id', '=', $this->getOwnerId());
        $this->crud->setEntityNameStrings(
            trans('crud.labels.recipe_review'),
            trans('crud.labels.recipe_reviews')
        );

        $this->addColumns();
        $this->addDefaultSorting();
        $this->addFields();
        $this->crud->addButtonFromView('relation_line', 'bfm_review_comments', 'bfm_review_comments');
        $this->crud->addButtonFromView('line', 'bfm_preview', 'bfm_preview', 'end');
        $this->addRelationButtons();
        $this->addBreadcrumbs();
    }

    /**
     * @param ReviewCrudRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(ReviewCrudRequest $request)
    {
        return parent::storeCrud($request->processTags());
    }

    /**
     * @param ReviewCrudRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(ReviewCrudRequest $request)
    {
        return parent::updateCrud($request->processTags());
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
            'name' => 'user_id',
            'label' => trans('crud.labels.author'),
            'options' => User::all()->sortBy('fullName')->pluck('fullName', 'id'),
            'placeholder' => trans('crud.placeholders.any')
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
            'type' => 'bfm_rating',
            'name' => 'rating',
            'label' => trans('crud.labels.rating'),
        ]);
        $this->crud->addColumn([
            'name' => 'reports',
            'label' => trans('crud.labels.reports'),
        ]);
        $this->crud->addColumn([
            'name' => 'views',
            'label' => trans('crud.labels.views'),
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
            'name' => 'title',
            'label' => $this->getRequiredLabel(trans('crud.labels.title')),
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
        if ($this->getOwnerId()) {
            $this->crud->addField([
                'type' => 'hidden',
                'name' => 'recipe_id',
                'value' => $this->getOwnerId()
            ]);
        } else {
            $this->crud->addField([
                'type' => 'select2',
                'name' => 'recipe_id',
                'label' => $this->getRequiredLabel(trans('crud.labels.recipe')),
                'entity' => 'recipe',
                'attribute' => 'title',
                'model' => 'App\Models\Recipe',
                'attributes' => [
                    'placeholder' => trans('crud.placeholders.select_recipe'),
                    'required' => '1'
                ]
            ]);
        }
        $this->crud->addField([
            'type' => 'textarea',
            'name' => 'details',
            'label' => $this->getRequiredLabel(trans('crud.labels.details')),
        ]);
        $this->crud->addField([
            'type' => 'number',
            'name' => 'rating',
            'label' => $this->getRequiredLabel(trans('crud.labels.rating')),
            'attributes' => [
                'min' => 1,
                'max' => 5
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
        $this->crud->addField([
            'type' => 'select2_multiple',
            'name' => 'chefs',
            'label' => trans('crud.labels.chefs'),
            'entity' => 'chefs',
            'attribute' => 'fullName',
            'model' => 'App\Models\Chef',
            'pivot' => true,
        ]);
    }
}
