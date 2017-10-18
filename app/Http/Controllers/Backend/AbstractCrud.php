<?php

namespace App\Http\Controllers\Backend;

use App\Enums\UserRole;
use App\Models\User;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use LiveControl\EloquentDataTable\DataTable;
use View;

/**
 * Class AbstractCrud
 * @package App\Http\Controllers\Backend
 */
abstract class AbstractCrud extends CrudController
{
    /**
     * @var string
     */
    const REQUIRED_MARKUP = ' <em>*</em>';

    /**
     * @var Request
     */
    public $request;

    /**
     * @var string
     */
    protected $model;

    /**
     * @var User
     */
    protected $currentUser;

    /**
     * @var array permissions
     */
    protected $permissions = [];

    /**
     * @var bool
     */
    protected $isRestricted = false;

    /**
     * @var bool
     */
    protected $hasPasswordField = false;

    /**
     * @var integer
     */
    private $ownerId;

    /**
     * @var string
     */
    private $ownerType;

    /**
     * @var string
     */
    private $ownerAttributeName;

    /**
     * ArticleVideoCrud constructor.
     * @param Request $request
     */
    public function __construct(Request $request)
    {
        $this->request = $request;
        $this->data['breadcrumbs'] = [];
        $this->data['filters'] = collect();
        $this->data['controller'] = (new \ReflectionClass($this))->getShortName();
        $this->data['order'] = [];
        $this->data['hasPasswordField'] = $this->hasPasswordField;
        $this->setHeading();

        parent::__construct();
    }

    /**
     * Setup CRUD.
     */
    public function setup()
    {
        $this->currentUser = Auth::user();
        $this->checkPermissions();
        $this->crud->setModel($this->model);
        $this->crud->enableAjaxTable();
        $this->restrictAccess();
        $this->setFilters();
        $this->applyFilters();
    }

    /**
     * @param int $id
     * @param int|null $relationId
     * @return \Backpack\CRUD\app\Http\Controllers\Response
     */
    public function edit($id, $relationId = null)
    {
        $entryId = $this->resolveId($id, $relationId);

        if ($this->isRestricted) {
            $entry = $this->crud->getEntry($entryId);
            if (isset($entry->user_id) && $entry->user_id != $this->currentUser->id) {
                return abort(403);
            }
        }

        $this->data['breadcrumbs'][] = [
            'url' => url($this->crud->route),
            'title' => $this->crud->entity_name_plural
        ];

        $this->data['breadcrumbs'][] = [
            'url' => '',
            'title' => trans('backpack::crud.edit')
        ];

        return parent::edit($entryId);
    }

    /**
     * @param int $id
     * @param int|null $relationId
     * @return string
     */
    public function destroy($id, $relationId = null)
    {
        $entryId = $this->resolveId($id, $relationId);

        if ($this->isRestricted) {
            $entry = $this->crud->getEntry($entryId);
            if (isset($entry->user_id) && $entry->user_id != $this->currentUser->id) {
                return abort(403);
            }
        }

        return parent::destroy($entryId);
    }

    /**
     * @param int $id
     * @param int|null $relationId
     * @return \Backpack\CRUD\app\Http\Controllers\Response
     */
    public function show($id, $relationId = null)
    {
        $this->data['breadcrumbs'][] = [
            'url' => url($this->crud->route),
            'title' => $this->crud->entity_name_plural
        ];

        $this->data['breadcrumbs'][] = [
            'url' => '',
            'title' => trans('crud.buttons.show')
        ];

        return parent::show($this->resolveId($id, $relationId));
    }

    /**
     * Display all rows in the database for this entity.
     *
     * @return \Backpack\CRUD\app\Http\Controllers\Response
     */
    public function index()
    {
        $this->data['breadcrumbs'][] = [
            'url' => url($this->crud->route),
            'title' => $this->crud->entity_name_plural
        ];

        return parent::index();
    }

    /**
     * Show the form for creating inserting a new row.
     *
     * @return \Backpack\CRUD\app\Http\Controllers\Response
     */
    public function create()
    {
        $this->data['breadcrumbs'][] = [
            'url' => url($this->crud->route),
            'title' => $this->crud->entity_name_plural
        ];

        $this->data['breadcrumbs'][] = [
            'url' => '',
            'title' => trans('backpack::crud.add')
        ];

        return parent::create();
    }

    /**
     * Reorder the items in the database using the Nested Set pattern.
     *
     * @return \Backpack\CRUD\app\Http\Controllers\CrudFeatures\Response
     */
    public function reorder()
    {
        $this->data['breadcrumbs'][] = [
            'url' => url($this->crud->route),
            'title' => $this->crud->entity_name_plural
        ];

        $this->data['breadcrumbs'][] = [
            'url' => '',
            'title' => trans('backpack::crud.reorder')
        ];

        return parent::reorder();
    }

    /**
     * Respond with the JSON of one or more rows, depending on the POST parameters.
     * @return array
     */
    public function search()
    {
        $this->crud->hasAccessOrFail('list');

        $columns = collect($this->crud->columns)
            ->reject(function ($column, $key) {
                return isset($column['type']) && $column['type'] == 'select_multiple';
            })
            ->pluck('name')
            ->merge($this->crud->model->getKeyName())
            ->toArray();

        $dataTable = new DataTable($this->crud->query, $columns);

        $dataTable->setFormatRowFunction(function ($entry) {
            $row_items = $this->crud->getRowViews($entry, $this->crud);

            if ($this->crud->buttons->where('stack', 'relation_line')->count()) {
                $row_items[] = View::make('crud::inc.button_stack', ['stack' => 'relation_line'])
                    ->with('crud', $this->crud)
                    ->with('entry', $entry)
                    ->render();
            }

            if ($this->crud->buttons->where('stack', 'line')->count()) {
                $row_items[] = View::make('crud::inc.button_stack', ['stack' => 'line'])
                    ->with('crud', $this->crud)
                    ->with('entry', $entry)
                    ->render();
            }

            if ($this->crud->details_row) {
                array_unshift($row_items, View::make('crud::columns.details_row_button')
                    ->with('crud', $this->crud)
                    ->with('entry', $entry)
                    ->render());
            }

            return $row_items;
        });

        return $dataTable->make();
    }

    /**
     * @return bool
     */
    protected function isAdminUser()
    {
        return $this->currentUser->hasRole(UserRole::label(UserRole::ROLE_ADMIN));
    }

    /**
     * @param string $heading
     */
    protected function setHeading($heading = '')
    {
        $this->data['heading'] = $heading;
    }

    /**
     * Deny or allow crud permission
     */
    protected function checkPermissions()
    {
        foreach ($this->permissions as $crudPermission => $userPermission) {
            if ($this->currentUser->can($userPermission)) {
                $this->crud->allowAccess($crudPermission);
            } else {
                $this->crud->denyAccess($crudPermission);
            }
        }
    }

    /**
     * Restrict access for non-admin users
     */
    protected function restrictAccess()
    {
        if (!$this->isAdminUser()) {
            $this->isRestricted = true;
            $this->filterByUser();
        }
    }

    /**
     * Get article ID from URL
     *
     * @return void
     */
    protected function setOwnerId()
    {
        $this->ownerId = $this->request->route()->getParameter('owner');
    }

    /**
     * @return int
     */
    protected function getOwnerId()
    {
        return $this->ownerId;
    }

    /**
     * @param string $model
     */
    protected function setOwnerType($model = '')
    {
        $this->ownerType = $model;
    }

    /**
     * @return string
     */
    protected function getOwnerType()
    {
        return $this->ownerType;
    }

    /**
     * @param string $name
     */
    protected function setOwnerAttributeName($name = '')
    {
        $this->ownerAttributeName = $name;
    }

    /**
     * @return string
     */
    protected function getOwnerAttributeName()
    {
        return $this->ownerAttributeName;
    }

    /**
     * Restrict access to content by user ID for non-admin users
     */
    protected function filterByUser()
    {
        $this->crud->addClause('where', 'user_id', '=', $this->currentUser->id);
    }

    /**
     * Set CRUD filters
     */
    protected function setFilters()
    {
    }

    /**
     * @param array $filter
     */
    protected function addFilter($filter = [])
    {
        if (isset($filter['name'])) {
            if (empty($filter['type'])) {
                $filter['type'] = 'text';
            }

            $filter['view'] = 'vendor.backpack.crud.filters.' . $filter['type'];

            if ('select2' == $filter['type']) {
                if (empty($filter['options'])) {
                    $filter['options'] = [
                        '1' => trans('crud.helpers.yes'),
                        '0' => trans('crud.helpers.no')
                    ];
                }

                if (empty($filter['placeholder'])) {
                    $filter['placeholder'] = trans('crud.placeholders.any');
                }
            }

            if (!empty(session('backpack.filters'))) {
                $filters = session('backpack.filters');
                $controller = $this->data['controller'];

                if (isset($filters[$controller])) {
                    $filtered = $this->unsetEmptyFilters($filters[$controller]);

                    if (isset($filtered[$filter['name']])) {
                        $filter['default'] = $filtered[$filter['name']];
                    }
                }
            }

            $this->data['filters'][$filter['name']] = $filter;
        }
    }

    /**
     * @param array $filters
     * @return array
     */
    private function unsetEmptyFilters($filters)
    {
        return array_filter($filters, function ($value) {
            if (is_array($value)) {
                return !empty($value);
            } else {
                return strlen($value);
            }
        });
    }


    /**
     * Apply CRUD filters
     */
    private function applyFilters()
    {
        if (!empty(session('backpack.filters'))) {
            $filters = session('backpack.filters');
            $controller = $this->data['controller'];
            if (isset($filters[$controller])) {
                $filtersList = $this->data['filters'];
                $filtered = $this->unsetEmptyFilters($filters[$controller]);

                foreach ($filtered as $name => $value) {
                    if (isset($filtersList[$name])) {
                        $this->applyFilter($filtersList[$name], $name, $value);
                    }
                }
            }
        }
    }

    /**
     * Apply CRUD filter
     *
     * @param array $filter
     * @param string $name
     * @param mixed $value
     */
    private function applyFilter($filter, $name, $value)
    {
        switch ($filter['type']) {
            case 'select2':
                if (empty($filter['relation']) || empty($filter['attribute'])) {
                    $this->crud->addClause('where', $name, '=', $value);
                } else {
                    $this->crud->addClause(
                        'whereHas',
                        $filter['relation'],
                        function ($query) use ($filter, $value) {
                            $query->where($filter['attribute'], '=', $value);
                        }
                    );
                }
                break;
            case 'date_range':
                if (!empty($value['from'])) {
                    $from = $this->formatDateFrom($value['from']);
                    $this->crud->addClause('where', $name, '>=', $from);
                }

                if (!empty($value['to'])) {
                    $to = $this->formatDateTo($value['to']);
                    $this->crud->addClause('where', $name, '<=', $to);
                }
                break;
            case 'text':
            default:
                $this->crud->addClause('where', $name, 'like', '%'.$value.'%');
                break;
        }
    }

    /**
     * @param string $value
     * @return string
     */
    private function formatDateFrom($value)
    {
        $carbon = Carbon::createFromFormat(
            config('backpack.base.default_date_format'),
            $value
        );
        $carbon->hour(0);
        $carbon->minute(0);
        $carbon->second(0);

        return $carbon->toDateTimeString();
    }

    /**
     * @param string $value
     * @return string
     */
    private function formatDateTo($value)
    {
        $carbon = Carbon::createFromFormat(
            config('backpack.base.default_date_format'),
            $value
        );
        $carbon->hour(23);
        $carbon->minute(59);
        $carbon->second(59);

        return $carbon->toDateTimeString();
    }

    /**
     * @param int $id
     * @param int|null $relationId
     * @return int
     */
    private function resolveId($id, $relationId)
    {
        if (empty($relationId)) {
            return $id;
        } else {
            $this->checkOwner($id, $relationId);
            return $relationId;
        }
    }

    /**
     * @param int $id
     * @param int $relationId
     * @return void
     */
    private function checkOwner($id, $relationId)
    {
        $relation = $this->crud->model->findOrFail($relationId);

        if ($this->crud->model->isPolymorphic()) {
            if (($this->getOwnerType() != $relation->owner_type || $id != $relation->owner_id)) {
                abort(404);
            }
        } else {
            if ($id != $relation->{$this->getOwnerAttributeName()}) {
                abort(404);
            }
        }
    }

    /**
     * @param string $label
     * @return string
     */
    protected function getRequiredLabel($label)
    {
        return $label . self::REQUIRED_MARKUP;
    }

    /**
     * @param string $field
     * @param string $direction
     */
    protected function addDefaultSorting($field = 'updated_at', $direction = 'desc')
    {
        $columns = collect($this->crud->getColumns());
        if ($columns->count() > 0) {
            $index = $columns->search(function ($item, $key) use ($field) {
                return $item['name'] == $field;
            });

            $this->data['order'] = '[['.$index.', "'.$direction.'"]]';
        }
    }

    /**
     * @param string $size
     * @param string $types
     * @return string
     */
    protected function getImageHint($size, $types = 'JPEG, JPG, PNG, GIF')
    {
        return implode(' ', [
            trans('crud.hints.recommended_image_size'),
            $size . '.',
            trans('crud.hints.allowed_file_types') . ':',
            $types . '.'
        ]);
    }
}
