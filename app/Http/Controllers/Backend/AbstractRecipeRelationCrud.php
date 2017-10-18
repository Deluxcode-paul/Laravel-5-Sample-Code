<?php

namespace App\Http\Controllers\Backend;

use App\Facades\KosherHelper;
use App\Models\Recipe;

abstract class AbstractRecipeRelationCrud extends AbstractCrud
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
        $this->setOwnerAttributeName('recipe_id');
        $this->checkOwnerExistence();
        $this->setRecipeId();
    }

    /**
     * Set recipe ID
     */
    protected function setRecipeId()
    {
        $this->data['recipeId'] = $this->getOwnerId();
    }

    /**
     * Check if owner exists
     */
    protected function checkOwnerExistence()
    {
        $this->owner = Recipe::find($this->getOwnerId());
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
            'url' => url('admin/recipes'),
            'title' => trans('crud.labels.recipes')
        ];
        $title = KosherHelper::trimForBreadcrumbs($this->owner->title);
        $this->setHeading($title);
        $this->data['breadcrumbs'][] = [
            'url' => url('admin/recipes/' . $this->owner->id . '/edit'),
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
        $this->crud->addButtonFromView('relation_top', 'bfm_gallery', 'relation_top.bfm_recipe_gallery');
        $this->crud->addButtonFromView('relation_top', 'bfm_videos', 'relation_top.bfm_recipe_videos');
        $this->crud->addButtonFromView('relation_top', 'bfm_recipe_ingredients', 'relation_top.bfm_recipe_ingredients');
        $this->crud->addButtonFromView('relation_top', 'bfm_recipe_cooking', 'relation_top.bfm_recipe_cooking');
        if ($this->isAdminUser()) {
            $this->crud->addButtonFromView('relation_top', 'bfm_reviews', 'relation_top.bfm_reviews');
            $this->crud->addButtonFromView('relation_top', 'bfm_recipe_questions', 'relation_top.bfm_recipe_questions');
        }
        $this->crud->addButtonFromView('relation_top', 'bfm_recipe_preview', 'relation_top.bfm_recipe_preview');
    }
}
