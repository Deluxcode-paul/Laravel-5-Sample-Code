<a href="{{ url('admin/community-questions/'.$entry->getKey().'/answers') }}" class="btn btn-xs btn-default">
    <i class="fa fa-comments"></i> {{ trans('crud.buttons.answers') }} <span class="badge">{{ $entry->answers->count() }}</span>
</a>