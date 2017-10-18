<a href="{{ url($crud->route.'/'.$entry->getKey().'/questions') }}" class="btn btn-xs btn-default">
    <i class="fa fa-question"></i> {{ trans('crud.buttons.questions') }} <span class="badge">{{ $entry->questions->count() }}</span>
</a>