<?php

namespace App\Http\Controllers\Backend;

use App\Facades\KosherHelper;
use App\Models\Article;

abstract class AbstractArticleRelationCrud extends AbstractCrud
{
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
        $this->setOwnerAttributeName('article_id');
        $this->checkOwnerExistence();
        $this->setArticleId();
    }

    /**
     * Set recipe ID
     */
    protected function setArticleId()
    {
        $this->data['articleId'] = $this->getOwnerId();
    }

    /**
     * Check if owner exists
     */
    protected function checkOwnerExistence()
    {
        $this->owner = Article::find($this->getOwnerId());
        if (empty($this->owner)) {
            abort(404);
        }
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
        $title = KosherHelper::trimForBreadcrumbs($this->owner->title);
        $this->setHeading($title);
        $this->data['breadcrumbs'][] = [
            'url' => url('admin/articles/' . $this->owner->id . '/edit'),
            'title' => $title
        ];
    }

    /**
     * Add form buttons
     */
    protected function addFormButtons()
    {
        $this->crud->addButtonFromView('form', 'bfm_save_and_new', 'form.bfm_save_and_new');
        $this->crud->addButtonFromView('form', 'bfm_save', 'form.bfm_save');
        $this->crud->addButtonFromView('form', 'bfm_cancel', 'form.bfm_cancel');
    }

    /**
     * Add form buttons
     */
    protected function addRelationButtons()
    {
        $this->crud->addButtonFromView('relation_top', 'bfm_article_videos', 'relation_top.bfm_article_videos');
        if ($this->isAdminUser()) {
            $this->crud->addButtonFromView('relation_top', 'bfm_article_comments', 'relation_top.bfm_article_comments');
        }
    }
}
