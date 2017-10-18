<?php

namespace App\Http\Controllers\Backend;

use App\Facades\KosherHelper;
use App\Http\Requests\Backend\ReviewCommentCrudRequest;
use App\Models\Review;
use App\Models\User;

/**
 * Class ReviewCommentCrud
 * @package App\Http\Controllers\Backend
 */
class ReviewCommentCrud extends AbstractRecipeRelationCrud
{
    /**
     * @var string
     */
    protected $model = 'App\Models\ReviewComment';

    /**
     * Setup CRUD.
     */
    public function setup()
    {
        parent::setup();

        $this->setOwnerAttributeName('review_id');

        $this->crud->setRoute('admin/reviews/' . $this->getOwnerId() . '/comments');
        $this->crud->addClause('where', 'review_id', '=', $this->getOwnerId());
        $this->crud->setEntityNameStrings(
            trans('crud.labels.review_comment'),
            trans('crud.labels.review_comments')
        );

        $this->addColumns();
        $this->addDefaultSorting();
        $this->addFields();
        $this->addFormButtons();
        $this->addRelationButtons();
        $this->addBreadcrumbs();
    }

    /**
     * @param ReviewCommentCrudRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(ReviewCommentCrudRequest $request)
    {
        return parent::storeCrud();
    }

    /**
     * @param ReviewCommentCrudRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(ReviewCommentCrudRequest $request)
    {
        return parent::updateCrud();
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
    }

    /**
     * Check if owner exists
     */
    protected function checkOwnerExistence()
    {
        $this->owner = Review::find($this->getOwnerId());
        if (empty($this->owner)) {
            abort(404);
        }
    }

    /**
     * Set recipe ID
     */
    protected function setRecipeId()
    {
        $this->data['recipeId'] = $this->owner->recipe_id;
    }

    /**
     * Add breadcrumbs
     */
    protected function addBreadcrumbs()
    {
        $this->data['breadcrumbs'][] = [
            'url' => url('admin/recipes'),
            'title' => trans('crud.labels.recipes')
        ];
        $recipeTitle = KosherHelper::trimForBreadcrumbs($this->owner->recipe->title);
        $this->setHeading($recipeTitle);
        $this->data['breadcrumbs'][] = [
            'url' => url('admin/recipes/' . $this->owner->recipe_id . '/edit'),
            'title' => $recipeTitle
        ];
        $this->data['breadcrumbs'][] = [
            'url' => url('admin/recipes/' . $this->owner->recipe_id . '/reviews'),
            'title' => trans('crud.labels.recipe_reviews')
        ];
        $this->data['breadcrumbs'][] = [
            'url' => url('admin/recipes/' . $this->owner->recipe_id . '/reviews/' . $this->owner->id . '/edit'),
            'title' => KosherHelper::trimForBreadcrumbs($this->owner->title)
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
            'attributes' => [
                'data-orderable' => false
            ]
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
            'name' => 'review_id',
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
