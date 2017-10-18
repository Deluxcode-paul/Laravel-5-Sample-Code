<div class="form-input">
    <input type="{{ $field->data['fieldType'] }}"
           name="{{ $field->getInputName() }}"
           value="{{ $field->getValue() }}"
           placeholder="{{ $field->placeholder }}"
           @if($field->is_required) required @endif
            {{ $field->validation_fe }}>
</div>
