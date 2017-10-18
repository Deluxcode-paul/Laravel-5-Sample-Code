<ul>
    @foreach($links as $link)
        @if ($link['selected'])
            <li><span>{{ $link['label'] }}</span></li>
        @else
            <li><a data-value ={{ $link['label'] }} href="{{ $link['link'] }}">{{ $link['label'] }}</a></li>
        @endif
    @endforeach
</ul>