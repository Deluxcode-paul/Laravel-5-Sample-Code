@if (url($crud->route) == url('admin/recipes/'.$recipeId.'/reviews'))
    <span class="btn btn-sm btn-default btn-primary active">
        <i class="fa fa-star-half-o"></i> {{ trans('crud.buttons.reviews') }}
    </span>
@else
    <a href="{{ url('admin/recipes/'.$recipeId.'/reviews') }}" class="btn btn-sm btn-default @if('crud.reviews/{owner}/comments.index' == Route::getCurrentRoute()->getName()) btn-primary active @endif">
        <i class="fa fa-star-half-o"></i> {{ trans('crud.buttons.reviews') }}
    </a>
@endif