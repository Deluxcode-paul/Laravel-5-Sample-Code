<a href="{{ url('admin/reviews/'.$entry->getKey().'/comments') }}" class="btn btn-xs btn-default">
    <i class="fa fa-comments"></i> {{ trans('crud.buttons.comments') }} <span class="badge">{{ $entry->comments->count() }}</span>
</a>