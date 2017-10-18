<td>
    @unless (empty($entry->{$column['entity']}()->getResults()))
        @if (empty($column['route']))
            <a href="{{ $entry->{$column['entity']}()->getResults()->getUrl() }}" target="_blank">
                {{ $entry->{$column['entity']}()->getResults()->{$column['attribute']} }}
            </a>
        @else
            <a href="{{ route($column['route'], ['id' => $entry->{$column['name']}]) }}">
                {{ $entry->{$column['entity']}()->getResults()->{$column['attribute']} }}
            </a>
        @endif
    @endunless
</td>