<a href="{{ url('admin/article-comments/'.$entry->getKey().'/replies') }}" class="btn btn-xs btn-default">
    <i class="fa fa-comments"></i> {{ trans('crud.buttons.replies') }} <span class="badge">{{ $entry->replies()->count() }}</span>
</a>