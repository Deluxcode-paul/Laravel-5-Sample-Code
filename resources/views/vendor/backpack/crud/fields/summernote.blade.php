@backpackAssets('summernote')
@backpackAssets('crud/fields/summernote.js')

<div @include('crud::inc.field_wrapper_attributes') >
    <label>{!! $field['label'] !!}</label>
    <textarea
            name="{{ $field['name'] }}"
            @include('crud::inc.field_attributes', ['default_class' =>  'form-control summernote'])
    >{{ old($field['name']) ? old($field['name']) : (isset($field['value']) ? $field['value'] : (isset($field['default']) ? $field['default'] : '' )) }}</textarea>

    @if (isset($field['hint']))
        <p class="help-block">{!! $field['hint'] !!}</p>
    @endif
</div>
