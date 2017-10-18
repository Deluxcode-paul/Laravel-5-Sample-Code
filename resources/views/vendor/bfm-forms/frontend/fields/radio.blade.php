@foreach($field->data['options'] as $option)
    <div>
        {{ $option->title }}
        <input type="radio"
               name="{{ $field->getInputName() }}"
               value="{{ $option->value }}"
               @if($field->is_required) required @endif
               @if($option->value === $field->getValue())
               checked
                @endif>
    </div>
@endforeach
