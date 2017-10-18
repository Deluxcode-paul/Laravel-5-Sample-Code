<a href="{{ url($crud->route.'/'.$entry->getKey().'/comments') }}" class="btn btn-xs btn-default">
    <i class="fa fa-comment"></i> {{ trans('crud.buttons.comments') }} <span class="badge">{{ $entry->comments->count() }}</span>
</a>