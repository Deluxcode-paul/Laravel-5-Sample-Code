@if ($crud->hasAccess('delete'))
	<a href="{{ url($crud->route.'/'.$entry->getKey()) }}" class="btn btn-xs btn-default" data-button-type="delete" title="{{ trans('backpack::crud.delete') }}">
        <i class="fa fa-remove"></i>
    </a>
@endif