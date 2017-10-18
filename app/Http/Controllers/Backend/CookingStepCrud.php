<?php

namespace App\Http\Controllers\Backend;

use App\Facades\KosherHelper;
use App\Http\Requests\Backend\CookingStepCrudRequest;
use App\Models\RecipeCooking;

/**
 * Class CookingStepCrud
 * @package App\Http\Controllers\Backend
 */
class CookingStepCrud extends AbstractRecipeRelationCrud
{
    /**
     * @var string
     */
    protected $model = 'App\Models\CookingStep';

    /**
     * Setup CRUD.
     */
    public function setup()
    {
        parent::setup();

        $this->setOwnerAttributeName('cooking_id');

        $this->crud->setRoute('admin/directions/' . $this->getOwnerId() . '/steps');
        $this->crud->addClause('where', 'cooking_id', '=', $this->getOwnerId());
        $this->crud->setEntityNameStrings(
            trans('crud.labels.cooking_step'),
            trans('crud.labels.cooking_steps')
        );

        $this->crud->enableReorder('description');
        $this->crud->allowAccess('reorder');

        $this->addColumns();
        $this->addDefaultSorting('lft', 'asc');
        $this->addFields();
        $this->addFormButtons();
        $this->addRelationButtons();
        $this->addBreadcrumbs();
    }

    /**
     * @param CookingStepCrudRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(CookingStepCrudRequest $request)
    {
        return parent::storeCrud($request->processImages());
    }

    /**
     * @param CookingStepCrudRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(CookingStepCrudRequest $request)
    {
        return parent::updateCrud($request->processImages());
    }

    /**
     * Check if owner exists
     */
    protected function checkOwnerExistence()
    {
        $this->owner = RecipeCooking::find($this->getOwnerId());
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
            'url' => url('admin/recipes/' . $this->owner->recipe_id . '/directions'),
            'title' => trans('crud.labels.recipe_cooking')
        ];
        $this->data['breadcrumbs'][] = [
            'url' => url('admin/recipes/' . $this->owner->recipe_id . '/directions/' . $this->owner->id . '/edit'),
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
            'type' => 'bfm_reorder',
            'name' => 'lft',
            'label' => trans('crud.labels.step_number')
        ]);
        $this->crud->addColumn([
            'name' => 'description',
            'label' => trans('crud.labels.description'),
            'attributes' => [
                'data-orderable' => false
            ]
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
            'name' => 'cooking_id',
            'value' => $this->getOwnerId()
        ]);
        $this->crud->addField([
            'type' => 'tinymce_ingredient',
            'name' => 'description',
            'label' => $this->getRequiredLabel(trans('crud.labels.description')),
        ]);
        $this->crud->addField([
            'type' => 'browse',
            'name' => 'image',
            'label' => trans('crud.labels.image'),
            'hint' => $this->getImageHint('800 x 600px')
        ]);
    }
}
