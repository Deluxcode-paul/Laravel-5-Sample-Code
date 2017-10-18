<?php

namespace App\Http\Controllers\Backend;

use App\Facades\KosherHelper;
use App\Http\Requests\Backend\RecipeAnswerCrudRequest;
use App\Models\RecipeQuestion;
use App\Models\User;

/**
 * Class RecipeAnswerCrud
 * @package App\Http\Controllers\Backend
 */
class RecipeAnswerCrud extends AbstractRecipeRelationCrud
{
    /**
     * @var string
     */
    protected $model = 'App\Models\RecipeAnswer';

    /**
     * Setup CRUD.
     */
    public function setup()
    {
        parent::setup();

        $this->setOwnerAttributeName('recipe_question_id');

        $this->crud->setRoute('admin/recipe-questions/' . $this->getOwnerId() . '/answers');
        $this->crud->addClause('where', 'recipe_question_id', '=', $this->getOwnerId());
        $this->crud->setEntityNameStrings(
            trans('crud.labels.recipe_answer'),
            trans('crud.labels.recipe_answers')
        );

        $this->addColumns();
        $this->addDefaultSorting();
        $this->addFields();
        $this->addFormButtons();
        $this->addRelationButtons();
        $this->addBreadcrumbs();
    }

    /**
     * @param RecipeAnswerCrudRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(RecipeAnswerCrudRequest $request)
    {
        return parent::storeCrud();
    }

    /**
     * @param RecipeAnswerCrudRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(RecipeAnswerCrudRequest $request)
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
        $this->owner = RecipeQuestion::find($this->getOwnerId());
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
            'url' => url('admin/recipes/' . $this->owner->recipe_id . '/questions'),
            'title' => trans('crud.labels.recipe_questions')
        ];
        $this->data['breadcrumbs'][] = [
            'url' => url('admin/recipes/' . $this->owner->recipe_id . '/questions/' . $this->owner->id . '/edit'),
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
            'name' => 'recipe_question_id',
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
