<div class="form-input is-select">
    <select name="{{ $field->getInputName() }}"
            @if($field->is_multiple) multiple @endif
            @if($field->is_required) required @endif
            {{ $field->validation_fe }}>
        @if($field->isShowDefaultValue())
            <option value="">{{ $field->placeholder }}</option>
        @endif
        @foreach($field->data['options'] as $option)
            <option value="{{ $option->value }}"
            @if($option->isSelected || $field->getValue() == $option->value) selected @endif>{{ $option->title }}</option>
        @endforeach
    </select>
</div>
@include('partials.separator')