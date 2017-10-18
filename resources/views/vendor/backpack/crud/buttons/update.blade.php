@if ($crud->hasAccess('update'))
	<a href="{{ url($crud->route.'/'.$entry->getKey().'/edit') }}" class="btn btn-xs btn-default" title="{{ trans('backpack::crud.edit') }}">
        @if ($entry->isEditable())
            <i class="fa fa-pencil"></i>
        @else
            <i class="fa fa-eye"></i>
        @endif
    </a>
@endif