<?php

namespace App\Http\Controllers\Backend;

use App\Http\Requests\Backend\ArticleCategoryCrudRequest;

/**
 * Class ArticleCategoryCrud
 * @package App\Http\Controllers\Backend
 */
class ArticleCategoryCrud extends AbstractCrud
{
    /**
     * @var string
     */
    protected $model = 'App\Models\ArticleCategory';

    /**
     * RecipeCategoryCrud constructor.
     */
    public function setup()
    {
        parent::setup();

        $this->crud->setRoute('admin/article-categories');
        $this->crud->setEntityNameStrings(
            trans('crud.labels.article_category'),
            trans('crud.labels.article_categories')
        );

        $this->addColumns();
        $this->addDefaultSorting();
        $this->addFields();
    }

    /**
     * @param ArticleCategoryCrudRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(ArticleCategoryCrudRequest $request)
    {
        return parent::storeCrud();
    }

    /**
     * @param ArticleCategoryCrudRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(ArticleCategoryCrudRequest $request)
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
            'name' => 'title',
            'label' => trans('crud.labels.title'),
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
    }
}
