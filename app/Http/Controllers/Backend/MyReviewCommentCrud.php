<?php

namespace App\Http\Controllers\Backend;

use App\Http\Requests\Backend\MyReviewCommentCrudRequest;
use Illuminate\Support\Facades\DB;

/**
 * Class MyReviewCommentCrud
 * @package App\Http\Controllers\Backend
 */
class MyReviewCommentCrud extends AbstractCrud
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

        $this->crud->setRoute('admin/my-review-comments');
        $this->crud->addClause('where', 'user_id', '=', $this->currentUser->id);
        $this->crud->setEntityNameStrings(
            trans('crud.labels.review_comment'),
            trans('crud.labels.review_comments')
        );

        $this->crud->denyAccess('create');

        $this->addColumns();
        $this->addDefaultSorting();
        $this->addFields();
    }

    /**
     * @param MyReviewCommentCrudRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(MyReviewCommentCrudRequest $request)
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
            'name' => 'review_id',
            'label' => trans('crud.labels.review'),
            'options' => DB::table('review_comments')
                ->join('reviews', 'reviews.id', '=', 'review_comments.review_id')
                ->select('reviews.title', 'reviews.id')
                ->where('review_comments.user_id', $this->currentUser->id)
                ->get()->sortBy('title')->pluck('title', 'id'),
            'placeholder' => trans('crud.placeholders.any'),
            'size' => 'col-md-4'
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
     * Add CRUD columns
     *
     * @return void
     */
    private function addColumns()
    {
        $this->crud->addColumn([
            'type' => 'bfm_relation_link',
            'name' => 'review_id',
            'label' => trans('crud.labels.review'),
            'entity' => 'review',
            'attribute' => 'title',
            'attributes' => [
                'data-orderable' => false
            ]
        ]);
        $this->crud->addColumn([
            'name' => 'details',
            'label' => trans('crud.labels.details'),
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
            'type' => 'select2',
            'name' => 'review_id',
            'label' => $this->getRequiredLabel(trans('crud.labels.review')),
            'entity' => 'review',
            'attribute' => 'title',
            'model' => 'App\Models\Review',
            'attributes' => [
                'disabled' => 'disabled'
            ]
        ], 'update');
        $this->crud->addField([
            'type' => 'textarea',
            'name' => 'details',
            'label' => $this->getRequiredLabel(trans('crud.labels.details')),
        ]);
    }
}
