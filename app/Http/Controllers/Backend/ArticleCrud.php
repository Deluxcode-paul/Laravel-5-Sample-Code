<?php

namespace App\Http\Controllers\Backend;

use App\Http\Requests\Backend\ArticleCrudRequest;
use App\Models\ArticleCategory;
use App\Models\TopChef;

/**
 * Class ArticleCrud
 * @package App\Http\Controllers\Backend
 */
class ArticleCrud extends AbstractCrud
{
    /**
     * @var string
     */
    protected $model = 'App\Models\Article';

    /**
     * Setup CRUD.
     */
    public function setup()
    {
        parent::setup();

        $this->crud->setRoute('admin/articles');
        $this->crud->setEntityNameStrings(
            trans('crud.labels.article'),
            trans('crud.labels.articles')
        );

        $this->addLineButtons();
        $this->addColumns();
        $this->addDefaultSorting();
        $this->addFields();
        $this->addFormButtons();
    }

    /**
     * @param ArticleCrudRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(ArticleCrudRequest $request)
    {
        return parent::storeCrud($request->processImages()->processDates()->processTags());
    }

    /**
     * @param ArticleCrudRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(ArticleCrudRequest $request)
    {
        return parent::updateCrud($request->processImages()->processDates()->processTags());
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
        if (!$this->isRestricted) {
            $this->addFilter([
                'type' => 'select2',
                'name' => 'user_id',
                'label' => trans('crud.labels.author'),
                'options' => TopChef::all()->sortBy('fullName')->pluck('fullName', 'id'),
                'placeholder' => trans('crud.placeholders.any')
            ]);
        }
        $this->addFilter([
            'type' => 'select2',
            'name' => 'category_id',
            'label' => trans('crud.labels.category'),
            'options' => ArticleCategory::all()->sortBy('title')->pluck('title', 'id'),
            'placeholder' => trans('crud.placeholders.any')
        ]);
        $this->addFilter([
            'type' => 'select2',
            'name' => 'is_featured',
            'label' => trans('crud.labels.is_featured'),
            'size' => 'col-md-1'
        ]);
        $this->addFilter([
            'type' => 'select2',
            'name' => 'is_banner',
            'label' => trans('crud.labels.is_banner'),
            'size' => 'col-md-1'
        ]);
        $this->addFilter([
            'type' => 'date_range',
            'name' => 'published_at',
            'label' => trans('crud.labels.published_at')
        ]);
    }

    /**
     * Add buttons
     */
    private function addLineButtons()
    {
        $this->crud->addButtonFromView('line', 'bfm_preview', 'bfm_preview', 'end');
        if ($this->isAdminUser()) {
            $this->crud->addButtonFromView('relation_line', 'bfm_article_comments', 'bfm_article_comments');
        }
        $this->crud->addButtonFromView('relation_line', 'bfm_videos', 'bfm_videos');
    }

    /**
     * Add form buttons
     */
    private function addFormButtons()
    {
        $this->addFormHeaderButtons();
        $this->crud->addButtonFromView('form', 'bfm_save_and_publish', 'form.bfm_save_and_publish');
        $this->crud->addButtonFromView('form', 'bfm_cancel', 'form.bfm_cancel');
    }

    /**
     * Add form header buttons
     */
    private function addFormHeaderButtons()
    {
        $this->crud->addButtonFromView('form_header', 'bfm_videos', 'bfm_videos');
        if ($this->isAdminUser()) {
            $this->crud->addButtonFromView('form_header', 'bfm_article_comments', 'bfm_article_comments');
        }
        $this->crud->addButtonFromView('form_header', 'bfm_preview', 'bfm_preview');
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
        if (!$this->isRestricted) {
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
        }
        $this->crud->addColumn([
            'type' => 'bfm_relation_link',
            'name' => 'category_id',
            'label' => trans('crud.labels.category'),
            'entity' => 'category',
            'attribute' => 'title',
            'route' => 'crud.article-categories.edit',
            'attributes' => [
                'data-orderable' => false
            ]
        ]);
        $this->crud->addColumn([
            'name' => 'published_at',
            'label' => trans('crud.labels.published_at'),
        ]);
        $this->crud->addColumn([
            'type' => 'bfm_checkbox',
            'name' => 'is_featured',
            'label' => trans('crud.labels.is_featured'),
        ]);
        $this->crud->addColumn([
            'type' => 'bfm_checkbox',
            'name' => 'is_banner',
            'label' => trans('crud.labels.is_banner'),
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
        if ($this->isRestricted) {
            $this->crud->addField([
                'type' => 'hidden',
                'name' => 'user_id',
                'value' => $this->currentUser->id,
            ]);
        } else {
            $this->crud->addField([
                'type' => 'select2',
                'name' => 'user_id',
                'label' => $this->getRequiredLabel(trans('crud.labels.author')),
                'entity' => 'user',
                'attribute' => 'fullName',
                'model' => 'App\Models\TopChef',
                'attributes' => [
                    'placeholder' => trans('crud.placeholders.select_author'),
                    'required' => '1'
                ]
            ]);
        }
        $this->crud->addField([
            'type' => 'select2',
            'name' => 'category_id',
            'label' => $this->getRequiredLabel(trans('crud.labels.category')),
            'entity' => 'category',
            'attribute' => 'title',
            'model' => 'App\Models\ArticleCategory',
            'attributes' => [
                'placeholder' => trans('crud.placeholders.select_category'),
                'required' => '1'
            ]
        ]);
        $this->crud->addField([
            'name' => 'title',
            'label' => $this->getRequiredLabel(trans('crud.labels.title')),
        ]);
        $this->crud->addField([
            'type' => 'bfm_slug',
            'name' => 'slug',
            'label' => trans('crud.labels.slug'),
            'hint' => trans('crud.hints.slug'),
            'route' => 'article.short'
        ]);
        $this->crud->addField([
            'type' => 'browse',
            'name' => 'image',
            'label' => $this->getRequiredLabel(trans('crud.labels.image')),
            'hint' => $this->getImageHint('1920 x 1200px')
        ]);
        $this->crud->addField([
            'type' => 'tinymce_article',
            'name' => 'content',
            'label' => $this->getRequiredLabel(trans('crud.labels.content')),
        ]);
        $this->crud->addField([
            'type' => 'date_picker',
            'name' => 'published_at',
            'label' => $this->getRequiredLabel(trans('crud.labels.published_at')),
        ]);
        $this->crud->addField([
            'type' => 'checkbox',
            'name' => 'is_featured',
            'label' => trans('crud.labels.is_featured'),
        ]);
        $this->crud->addField([
            'type' => 'checkbox',
            'name' => 'is_banner',
            'label' => trans('crud.labels.is_banner'),
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
