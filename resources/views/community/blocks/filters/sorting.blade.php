<div>
    <ul>
        @foreach($sorting as $value => $label)
            @if (!empty($sort_value) && ($sort_value == $value))
                <li><span>{{ $label }}</span></li>
            @else
                <li><a href="?sort={{ $value }}">{{ $label }}</a></li>
            @endif
        @endforeach
    </ul>
</div>
