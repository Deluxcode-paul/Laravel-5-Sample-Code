<a href="{{ url($crud->route.'/'.$entry->getKey().'/ingredients') }}" class="btn btn-xs btn-default">
    <i class="fa fa-flask"></i> {{ trans('crud.buttons.ingredients') }} <span class="badge">{{ $entry->ingredients->count() }}</span>
</a>
