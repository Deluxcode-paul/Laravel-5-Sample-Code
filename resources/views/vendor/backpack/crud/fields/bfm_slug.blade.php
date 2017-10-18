<div @include('crud::inc.field_wrapper_attributes') >
    <label>{!! $field['label'] !!}</label>

    @if (isset($entry->id) && isset($field['route']))
        <div class="input-group">
            <div class="input-group-addon">{{ route($field['route'], [$entry->id]) . '/' }}</div>
    @endif
            <input
                    type="text"
                    name="{{ $field['name'] }}"
                    value="{{ old($field['name']) ? old($field['name']) : (isset($field['value']) ? $field['value'] : (isset($field['default']) ? $field['default'] : '' )) }}"
                    @include('crud::inc.field_attributes')
            >
    @if (isset($entry->id))
        </div>
    @endif

    @if (isset($field['hint']))
        <p class="help-block">{!! $field['hint'] !!}</p>
    @endif
</div>