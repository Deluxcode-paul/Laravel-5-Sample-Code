@backpackAssets('select2')
@backpackAssets('crud/fields/bfm_ingredient_group.js')

<div @include('crud::inc.field_wrapper_attributes') >
    <label>{!! $field['label'] !!}</label>
    <input type="text" name="{{ $field['name'] }}" value="{{ old($field['name']) ? old($field['name']) : (empty($entry) ? '' : $entry->ingredientGroup->title) }}"
           data-separator="{{ $field['model']::SEPARATOR }}"
            @include('crud::inc.field_attributes', ['default_class' =>  'form-control select2-ingredient-group']) />

    @if (isset($field['hint']))
        <p class="help-block">{!! $field['hint'] !!}</p>
    @endif
</div>
