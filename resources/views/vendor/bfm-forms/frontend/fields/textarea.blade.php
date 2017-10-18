<div class="form-input">
    <textarea name="{{ $field->getInputName() }}"
          placeholder="{{ $field->placeholder }}"
          @if($field->is_required) required @endif
        {{ $field->validation_fe }}>{{ $field->getValue() }}</textarea>
</div>
