<a href="{{ url($crud->route.'/'.$entry->getKey().'/directions') }}" class="btn btn-xs btn-default">
    <i class="fa fa-cutlery"></i> {{ trans('crud.buttons.cooking') }} <span class="badge">{{ $entry->cooking->count() }}</span>
</a>
