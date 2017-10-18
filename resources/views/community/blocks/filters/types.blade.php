<div>
    <ul>
        @foreach($types as $value => $label)
            @if (!empty($type_value) && ($type_value == $value))
                <li><span>{{ $label }}</span></li>
            @else
                <li><a href="?type={{ $value }}">{{ $label }}</a></li>
            @endif
        @endforeach
    </ul>
</div>
