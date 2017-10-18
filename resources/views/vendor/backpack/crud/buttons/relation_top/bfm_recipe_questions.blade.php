@if (url($crud->route) == url('admin/recipes/'.$recipeId.'/questions'))
    <span class="btn btn-sm btn-default btn-primary active">
        <i class="fa fa-question"></i> {{ trans('crud.buttons.questions') }}
    </span>
@else
    <a href="{{ url('admin/recipes/'.$recipeId.'/questions') }}" class="btn btn-sm btn-default @if('crud.recipe-questions/{owner}/answers.index' == Route::getCurrentRoute()->getName()) btn-primary active @endif">
        <i class="fa fa-question"></i> {{ trans('crud.buttons.questions') }}
    </a>
@endif