<?php

namespace App\Http\Controllers\Backend;

use App\Http\Requests\Backend\MyRecipeQuestionCrudRequest;
use App\Models\Recipe;
use Illuminate\Support\Facades\DB;

/**
 * Class MyRecipeQuestionCrud
 * @package App\Http\Controllers\Backend
 */
class MyRecipeQuestionCrud extends AbstractCrud
{
    /**
     * @var string
     */
    protected $model = 'App\Models\RecipeQuestion';

    /**
     * Setup CRUD.
     */
    public function setup()
    {
        parent::setup();

        $this->crud->setRoute('admin/my-recipe-questions');
        $this->crud->addClause('where', 'user_id', '=', $this->currentUser->id);
        $this->crud->setEntityNameStrings(
            trans('crud.labels.recipe_question'),
            trans('crud.labels.recipe_questions')
        );

        $this->crud->denyAccess('create');

        $this->addColumns();
        $this->addDefaultSorting();
        $this->addFields();
        $this->crud->addButtonFromView('line', 'bfm_preview', 'bfm_preview', 'end');
    }

    /**
     * @param MyRecipeQuestionCrudRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(MyRecipeQuestionCrudRequest $request)
    {
        return parent::storeCrud($request->processTags());
    }

    /**
     * @param MyRecipeQuestionCrudRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(MyRecipeQuestionCrudRequest $request)
    {
        return parent::updateCrud($request->processTags());
    }

    /**
     * Set CRUD filters
     */
    protected function setFilters()
    {
        $this->addFilter([
            'type' => 'select2',
            'name' => 'recipe_id',
            'label' => trans('crud.labels.recipe'),
            'options' => DB::table('recipe_questions')
                ->join('recipes', 'recipes.id', '=', 'recipe_questions.recipe_id')
                ->select('recipes.title', 'recipes.id')
                ->where('recipe_questions.user_id', $this->currentUser->id)
                ->get()->sortBy('title')->pluck('title', 'id'),
            'placeholder' => trans('crud.placeholders.any'),
            'size' => 'col-md-4'
        ]);
        $this->addFilter([
            'name' => 'title',
            'label' => trans('crud.labels.title')
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
            'name' => 'recipe_id',
            'label' => trans('crud.labels.recipe'),
            'entity' => 'recipe',
            'attribute' => 'title',
            'attributes' => [
                'data-orderable' => false
            ]
        ]);
        $this->crud->addColumn([
            'name' => 'title',
            'label' => trans('crud.labels.title'),
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
            'type' => 'select2',
            'name' => 'recipe_id',
            'label' => $this->getRequiredLabel(trans('crud.labels.recipe')),
            'entity' => 'recipe',
            'attribute' => 'title',
            'model' => 'App\Models\Recipe',
            'attributes' => [
                'disabled' => 'disabled'
            ]
        ], 'update');
        $this->crud->addField([
            'name' => 'title',
            'label' => $this->getRequiredLabel(trans('crud.labels.title')),
        ]);
        $this->crud->addField([
            'type' => 'textarea',
            'name' => 'details',
            'label' => $this->getRequiredLabel(trans('crud.labels.details')),
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
