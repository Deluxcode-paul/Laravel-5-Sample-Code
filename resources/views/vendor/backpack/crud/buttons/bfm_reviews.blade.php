<a href="{{ url($crud->route.'/'.$entry->getKey().'/reviews') }}" class="btn btn-xs btn-default">
    <i class="fa fa-star-half-o"></i> {{ trans('crud.buttons.reviews') }} <span class="badge">{{ $entry->reviews->count() }}</span>
</a>