@if (url($crud->route) == url('admin/recipes/'.$recipeId.'/ingredients'))
    <span class="btn btn-sm btn-default btn-primary active">
        <i class="fa fa-flask"></i> {{ trans('crud.buttons.ingredients') }}
    </span>
@else
    <a href="{{ url('admin/recipes/'.$recipeId.'/ingredients') }}" class="btn btn-sm btn-default">
        <i class="fa fa-flask"></i> {{ trans('crud.buttons.ingredients') }}
    </a>
@endif
