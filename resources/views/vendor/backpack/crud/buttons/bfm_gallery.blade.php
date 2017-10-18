<a href="{{ url($crud->route.'/'.$entry->getKey().'/images') }}" class="btn btn-xs btn-default">
    <i class="fa fa-photo"></i> {{ trans('crud.buttons.gallery') }} <span class="badge">{{ $entry->galleryImages->count() }}</span>
</a>
