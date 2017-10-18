@foreach($field->data['options'] as $option)
    <label>
        <input type="checkbox"
               name="{{ $field->getInputName() }}"
               value="{{ $option->value }}"
               @if($field->is_required) required @endif
               @if($option->isSelected)
               checked
                @endif>
        {{ $option->title }}
    </label>
@endforeach
