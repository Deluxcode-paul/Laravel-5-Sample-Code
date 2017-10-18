<?php

namespace App\Http\Controllers\Backend;

use App\Enums\RecipeDifficulty;
use App\Http\Requests\Backend\RecipeCrudRequest;
use App\Models\Preference;
use App\Models\RecipeCategory;
use App\Models\Chef;

/**
 * Class RecipeCrud
 * @package App\Http\Controllers\Backend
 */
class RecipeCrud extends AbstractCrud
{
    /**
     * @var string
     */
    protected $model = 'App\Models\Recipe';

    /**
     * @var array User Permissions
     */
    protected $permissions = [
        'list' => 'recipes-list',
        'create' => 'recipe-create',
        'update' => 'recipe-update',
        'delete' => 'recipe-delete',
    ];

    /**
     * Setup CRUD.
     */
    public function setup()
    {
        parent::setup();

        $this->crud->setRoute('admin/recipes');
        $this->crud->setEntityNameStrings(
            trans('crud.labels.recipe'),
            trans('crud.labels.recipes')
        );

        $this->addColumns();
        $this->addDefaultSorting();
        $this->addFields();
        $this->addLineButtons();
        $this->addFormButtons();
    }

    /**
     * @param RecipeCrudRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(RecipeCrudRequest $request)
    {
        return parent::storeCrud($request->processImages()->processTags()->processCookTime());
    }

    /**
     * @param RecipeCrudRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(RecipeCrudRequest $request)
    {
        return parent::updateCrud($request->processImages()->processTags()->processCookTime());
    }

    /**
     * Add CRUD filters
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
                'label' => trans('crud.labels.chef'),
                'options' => Chef::all()->sortBy('fullName')->pluck('fullName', 'id'),
                'placeholder' => trans('crud.placeholders.any')
            ]);
        }
        $this->addFilter([
            'type' => 'select2',
            'name' => 'categories',
            'relation' => 'categories',
            'attribute' => 'category_id',
            'label' => trans('crud.labels.categories'),
            'options' => RecipeCategory::all()->sortBy('title')->pluck('title', 'id'),
            'placeholder' => trans('crud.placeholders.any')
        ]);
        $this->addFilter([
            'type' => 'select2',
            'name' => 'preference_id',
            'label' => trans('crud.labels.preference'),
            'options' => Preference::all()->sortBy('title')->pluck('title', 'id'),
            'placeholder' => trans('crud.placeholders.any'),
            'size' => 'col-md-1'
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
            'type' => 'select2',
            'name' => 'is_archive',
            'label' => trans('crud.labels.is_archive'),
            'size' => 'col-md-1'
        ]);
    }

    /**
     * Add CRUD buttons
     *
     * @return void
     */
    private function addLineButtons()
    {
        $this->crud->addButtonFromView('line', 'bfm_preview', 'bfm_preview', 'end');
        if ($this->isAdminUser()) {
            $this->crud->addButtonFromView('relation_line', 'bfm_recipe_questions', 'bfm_recipe_questions');
            $this->crud->addButtonFromView('relation_line', 'bfm_reviews', 'bfm_reviews');
        }
        $this->crud->addButtonFromView('relation_line', 'bfm_recipe_cooking', 'bfm_recipe_cooking');
        $this->crud->addButtonFromView('relation_line', 'bfm_recipe_ingredients', 'bfm_recipe_ingredients');
        $this->crud->addButtonFromView('relation_line', 'bfm_videos', 'bfm_videos');
        $this->crud->addButtonFromView('relation_line', 'bfm_gallery', 'bfm_gallery');
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
        $this->crud->addButtonFromView('form_header', 'bfm_gallery', 'bfm_gallery');
        $this->crud->addButtonFromView('form_header', 'bfm_videos', 'bfm_videos');
        $this->crud->addButtonFromView('form_header', 'bfm_recipe_ingredients', 'bfm_recipe_ingredients');
        $this->crud->addButtonFromView('form_header', 'bfm_recipe_cooking', 'bfm_recipe_cooking');
        if ($this->isAdminUser()) {
            $this->crud->addButtonFromView('form_header', 'bfm_reviews', 'bfm_reviews');
            $this->crud->addButtonFromView('form_header', 'bfm_recipe_questions', 'bfm_recipe_questions');
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
                'label' => trans('crud.labels.chef'),
                'entity' => 'user',
                'attribute' => 'fullName',
                'attributes' => [
                    'data-orderable' => false
                ]
            ]);
        }
        $this->crud->addColumn([
            'type' => 'select',
            'name' => 'preference_id',
            'label' => trans('crud.labels.preference'),
            'entity' => 'preference',
            'attribute' => 'title',
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
            'type' => 'bfm_checkbox',
            'name' => 'is_archive',
            'label' => trans('crud.labels.is_archive'),
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
        $this->addMainFields();
        $this->addSecondaryFields();
        $this->addTags();
        $this->addCheckboxFields();
    }

    /**
     * @return void
     */
    private function addMainFields()
    {
        $this->crud->addField([
            'name' => 'title',
            'label' => $this->getRequiredLabel(trans('crud.labels.title')),
        ]);
        $this->crud->addField([
            'type' => 'bfm_slug',
            'name' => 'slug',
            'label' => trans('crud.labels.slug'),
            'hint' => trans('crud.hints.slug'),
            'route' => 'recipe.view.short'
        ]);
        $this->crud->addField([
            'type' => 'browse',
            'name' => 'image',
            'label' => $this->getRequiredLabel(trans('crud.labels.image')),
            'hint' => $this->getImageHint('1920 x 1200px')
        ]);
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
                'label' => $this->getRequiredLabel(trans('crud.labels.chef')),
                'entity' => 'user',
                'attribute' => 'fullName',
                'model' => 'App\Models\Chef',
                'attributes' => [
                    'placeholder' => trans('crud.placeholders.select_chef'),
                    'required' => '1'
                ]
            ]);
        }
        $this->crud->addField([
            'type' => 'select2_multiple',
            'name' => 'categories',
            'label' => $this->getRequiredLabel(trans('crud.labels.categories')),
            'entity' => 'categories',
            'attribute' => 'title',
            'model' => 'App\Models\RecipeCategory',
            'pivot' => true,
            'attributes' => [
                'placeholder' => trans('crud.placeholders.select_categories')
            ]
        ]);
        $this->crud->addField([
            'type' => 'radio',
            'name' => 'preference_id',
            'label' => $this->getRequiredLabel(trans('crud.labels.preference')),
            'options' => Preference::pluck('title', 'id')->all(),
            'inline' => true
        ]);
        $this->crud->addField([
            'type' => 'bfm_cook_time',
            'name' => 'cook_time',
            'label' => $this->getRequiredLabel(trans('crud.labels.cook_time')),
            'attributes' => [
                'min' => 0
            ]
        ]);
        $this->crud->addField([
            'type' => 'number',
            'name' => 'serving',
            'label' => $this->getRequiredLabel(trans('crud.labels.serving')),
            'suffix' => trans('crud.helpers.persons'),
            'attributes' => [
                'min' => 0,
            ]
        ]);
        $this->crud->addField([
            'type' => 'select2_multiple',
            'name' => 'allergens',
            'label' => trans('crud.labels.contains'),
            'entity' => 'allergens',
            'attribute' => 'title',
            'model' => 'App\Models\Allergen',
            'pivot' => true,
            'attributes' => [
                'placeholder' => trans('crud.placeholders.select_allergens')
            ]
        ]);
    }

    /**
     * @return void
     */
    private function addSecondaryFields()
    {
        $this->crud->addField([
            'type' => 'textarea',
            'name' => 'description',
            'label' => trans('crud.labels.description'),
        ]);
        $this->crud->addField([
            'type' => 'select2_from_array',
            'name' => 'difficulty',
            'label' => trans('crud.labels.difficulty'),
            'options' => RecipeDifficulty::labels(),
            'allows_null' => false,
            'attributes' => [
                'placeholder' => trans('crud.placeholders.select_difficulty')
            ]
        ]);
        $this->crud->addField([
            'type' => 'select2',
            'name' => 'blessing_type_id',
            'label' => trans('crud.labels.blessing_type'),
            'entity' => 'blessingType',
            'attribute' => 'title',
            'model' => 'App\Models\BlessingType',
            'attributes' => [
                'placeholder' => trans('crud.placeholders.select_blessing')
            ]
        ]);
        $this->crud->addField([
            'type' => 'select2_multiple',
            'name' => 'holidays',
            'label' => trans('crud.labels.occasions'),
            'entity' => 'holidays',
            'attribute' => 'title',
            'model' => 'App\Models\Holiday',
            'pivot' => true,
            'attributes' => [
                'placeholder' => trans('crud.placeholders.select_occasions')
            ]
        ]);
        $this->crud->addField([
            'type' => 'select2_multiple',
            'name' => 'diets',
            'label' => trans('crud.labels.diets'),
            'entity' => 'diets',
            'attribute' => 'title',
            'model' => 'App\Models\Diet',
            'pivot' => true,
            'attributes' => [
                'placeholder' => trans('crud.placeholders.select_diets')
            ]
        ]);
        $this->crud->addField([
            'type' => 'select2_multiple',
            'name' => 'sources',
            'label' => trans('crud.labels.sources'),
            'entity' => 'sources',
            'attribute' => 'title',
            'model' => 'App\Models\Source',
            'pivot' => true,
            'attributes' => [
                'placeholder' => trans('crud.placeholders.select_sources')
            ]
        ]);
        $this->crud->addField([
            'type' => 'select2_multiple',
            'name' => 'cuisines',
            'label' => trans('crud.labels.cuisines'),
            'entity' => 'cuisines',
            'attribute' => 'title',
            'model' => 'App\Models\Cuisine',
            'pivot' => true,
            'attributes' => [
                'placeholder' => trans('crud.placeholders.select_cuisines')
            ]
        ]);
    }

    /**
     * @return void
     */
    private function addTags()
    {
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

    /**
     * @return void
     */
    private function addCheckboxFields()
    {
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
            'type' => 'checkbox',
            'name' => 'is_archive',
            'label' => trans('crud.labels.is_archive'),
        ]);
    }
}
