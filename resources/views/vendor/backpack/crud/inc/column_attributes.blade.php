@if (isset($column['attributes']))
    @foreach ($column['attributes'] as $attribute => $value)
        @if (is_string($attribute))
            {{ $attribute }}="{{ var_export($value, true) }}"
        @endif
    @endforeach
@endif