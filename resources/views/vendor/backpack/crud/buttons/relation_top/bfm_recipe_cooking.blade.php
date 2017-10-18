@if (url($crud->route) == url('admin/recipes/'.$recipeId.'/directions'))
    <span class="btn btn-sm btn-default btn-primary active">
        <i class="fa fa-cutlery"></i> {{ trans('crud.buttons.cooking') }}
    </span>
@else
    <a href="{{ url('admin/recipes/'.$recipeId.'/directions') }}" class="btn btn-sm btn-default @if('crud.directions/{owner}/steps.index' == Route::getCurrentRoute()->getName()) btn-primary active @endif">
        <i class="fa fa-cutlery"></i> {{ trans('crud.buttons.cooking') }}
    </a>
@endif