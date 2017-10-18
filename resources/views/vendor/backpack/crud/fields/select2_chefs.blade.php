@backpackAssets('select2')
@backpackAssets('crud/fields/select2_tags.js')

<div @include('crud::inc.field_wrapper_attributes') >
    <label>{!! $field['label'] !!}</label>
    <input type="text" name="{{ $field['name'] }}" value="{{ empty($entry) ? '' : $entry->getChefsString() }}"
           data-model="{{ $field['model'] }}"
           data-attribute="{{ $field['attribute'] }}"
           data-separator="{{ $field['model']::SEPARATOR }}"
            @include('crud::inc.field_attributes', ['default_class' =>  'form-control select2-tags']) />

    @if (isset($field['hint']))
        <p class="help-block">{!! $field['hint'] !!}</p>
    @endif
</div>
