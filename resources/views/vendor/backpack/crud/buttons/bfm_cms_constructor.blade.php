@if ($crud->hasAccess('update'))
<a href="{{ url($crud->route.'/constructor/page/'.$entry->getKey()) }}" class="btn btn-xs btn-default" title="{{ trans('crud.buttons.constructor') }}">
    <i class="fa fa-cubes"></i> @lang('crud.buttons.constructor')
</a>
@endif