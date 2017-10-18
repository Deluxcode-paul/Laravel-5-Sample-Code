<a href="{{ url($crud->route.'/'.$entry->getKey().'/videos') }}" class="btn btn-xs btn-default">
    <i class="fa fa-youtube-play"></i> {{ trans('crud.buttons.videos') }} <span class="badge">{{ $entry->videos->count() }}</span>
</a>
