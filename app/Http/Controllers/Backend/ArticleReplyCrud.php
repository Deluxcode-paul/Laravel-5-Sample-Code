<?php

namespace App\Http\Controllers\Backend;

use App\Facades\KosherHelper;
use App\Http\Requests\Backend\ArticleReplyCrudRequest;
use App\Models\ArticleComment;
use App\Models\User;

/**
 * Class ArticleReplyCrud
 * @package App\Http\Controllers\Backend
 */
class ArticleReplyCrud extends AbstractArticleRelationCrud
{
    /**
     * @var string
     */
    protected $model = 'App\Models\ArticleReply';

    /**
     * Setup CRUD.
     */
    public function setup()
    {
        parent::setup();

        $this->setOwnerAttributeName('article_comment_id');

        $this->crud->setRoute('admin/article-comments/' . $this->getOwnerId() . '/replies');
        $this->crud->addClause('where', 'article_comment_id', '=', $this->getOwnerId());
        $this->crud->setEntityNameStrings(
            trans('crud.labels.article_reply'),
            trans('crud.labels.article_replies')
        );

        $this->addColumns();
        $this->addDefaultSorting();
        $this->addFields();
        $this->addFormButtons();
        $this->addRelationButtons();
        $this->addBreadcrumbs();
    }

    /**
     * @param ArticleReplyCrudRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(ArticleReplyCrudRequest $request)
    {
        return parent::storeCrud();
    }

    /**
     * @param ArticleReplyCrudRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(ArticleReplyCrudRequest $request)
    {
        return parent::updateCrud();
    }

    /**
     * Check if owner exists
     */
    protected function checkOwnerExistence()
    {
        $this->owner = ArticleComment::find($this->getOwnerId());
        if (empty($this->owner)) {
            abort(404);
        }
    }

    /**
     * Set recipe ID
     */
    protected function setRecipeId()
    {
        $this->data['articleId'] = $this->owner->article_id;
    }

    /**
     * Add breadcrumbs
     */
    protected function addBreadcrumbs()
    {
        $this->data['breadcrumbs'][] = [
            'url' => url('admin/articles'),
            'title' => trans('crud.labels.articles')
        ];
        $title = KosherHelper::trimForBreadcrumbs($this->owner->article->title);
        $this->setHeading($title);
        $this->data['breadcrumbs'][] = [
            'url' => url('admin/articles/' . $this->owner->article_id . '/edit'),
            'title' => $title
        ];
        $this->data['breadcrumbs'][] = [
            'url' => url('admin/articles/' . $this->owner->article_id . '/comments'),
            'title' => trans('crud.labels.article_comments')
        ];
        $this->data['breadcrumbs'][] = [
            'url' => url('admin/articles/' . $this->owner->article_id . '/comments/' . $this->owner->id . '/edit'),
            'title' => KosherHelper::trimForBreadcrumbs($this->owner->title)
        ];
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
            'name' => 'article_comment_id',
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
