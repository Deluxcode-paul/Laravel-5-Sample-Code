@if (url($crud->route) == url('admin/recipes/'.$recipeId.'/images'))
    <span class="btn btn-sm btn-default btn-primary active">
        <i class="fa fa-photo"></i> {{ trans('crud.buttons.gallery') }}
    </span>
@else
    <a href="{{ url('admin/recipes/'.$recipeId.'/images') }}" class="btn btn-sm btn-default">
        <i class="fa fa-photo"></i> {{ trans('crud.buttons.gallery') }}
    </a>
@endif