<a href="{{ url('admin/directions/'.$entry->getKey().'/steps') }}" class="btn btn-xs btn-default">
    <i class="fa fa-list-ul"></i> {{ trans('crud.buttons.steps') }} <span class="badge">{{ $entry->steps->count() }}</span>
</a>
