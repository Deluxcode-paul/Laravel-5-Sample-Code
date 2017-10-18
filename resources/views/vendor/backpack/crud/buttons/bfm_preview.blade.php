@unless (empty($entry->getUrl()))
<a href="{{ $entry->getUrl() }}" class="btn btn-xs btn-default" target="_blank" title="{{ trans('crud.buttons.preview') }}">
    <i class="fa fa-search"></i>
</a>
@endunless