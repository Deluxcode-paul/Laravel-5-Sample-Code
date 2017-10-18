<p>@lang('common.view')</p>
<ul>
    @foreach(config('kosher.pagination.per_page_selector') as $per_page)
        @if (!empty($per_page_value) && ($per_page_value == $per_page))
            <li><span>{{ $per_page }}</span></li>
        @else
            <li><a href="?per_page={{ $per_page }}">{{ $per_page }}</a></li>
        @endif
    @endforeach
</ul>
