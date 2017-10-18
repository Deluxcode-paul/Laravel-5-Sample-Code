<?php

namespace App\Http\Controllers\Backend;

use App\Http\Requests\Backend\MyRecipeAnswerCrudRequest;
use App\Models\RecipeQuestion;
use Illuminate\Support\Facades\DB;

/**
 * Class MyRecipeAnswerCrud
 * @package App\Http\Controllers\Backend
 */
class MyRecipeAnswerCrud extends AbstractCrud
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

        $this->crud->setRoute('admin/my-recipe-answers');
        $this->crud->addClause('where', 'user_id', '=', $this->currentUser->id);
        $this->crud->setEntityNameStrings(
            trans('crud.labels.recipe_answer'),
            trans('crud.labels.recipe_answers')
        );

        $this->crud->denyAccess('create');

        $this->addColumns();
        $this->addDefaultSorting();
        $this->addFields();
    }

    /**
     * @param MyRecipeAnswerCrudRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(MyRecipeAnswerCrudRequest $request)
    {
        return parent::storeCrud();
    }

    /**
     * @param MyRecipeAnswerCrudRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(MyRecipeAnswerCrudRequest $request)
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
            'name' => 'question_id',
            'label' => trans('crud.labels.recipe_question'),
            'options' => DB::table('recipe_answers')
                ->join('recipe_questions', 'recipe_questions.id', '=', 'recipe_answers.recipe_question_id')
                ->select('recipe_questions.title', 'recipe_questions.id')
                ->where('recipe_answers.user_id', $this->currentUser->id)
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
            'name' => 'recipe_question_id',
            'label' => trans('crud.labels.recipe_question'),
            'entity' => 'question',
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
            'name' => 'recipe_question_id',
            'label' => $this->getRequiredLabel(trans('crud.labels.recipe_question')),
            'entity' => 'question',
            'attribute' => 'title',
            'model' => 'App\Models\RecipeQuestion',
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
