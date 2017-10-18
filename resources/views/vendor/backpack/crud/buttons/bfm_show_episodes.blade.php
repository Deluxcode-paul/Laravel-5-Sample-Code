<a href="{{ url($crud->route.'/'.$entry->getKey().'/episodes') }}" class="btn btn-xs btn-default">
    <i class="fa fa-youtube-play"></i> {{ trans('crud.buttons.episodes') }} <span class="badge">{{ $entry->videos->count() }}</span>
</a>