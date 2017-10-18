@backpackAssets('select2')
@backpackAssets('crud/fields/select2_multiple.js')

<div @include('crud::inc.field_wrapper_attributes') >
    <label>{!! $field['label'] !!}</label>
    <select
            name="{{ $field['name'] }}[]"
            @include('crud::inc.field_attributes', ['default_class' =>  'form-control select2-multiple'])
            multiple>

        @if (isset($field['model']))
            @foreach ($field['model']::all() as $connected_entity_entry)
                <option value="{{ $connected_entity_entry->getKey() }}"
                        @if ( (isset($field['value']) && in_array($connected_entity_entry->getKey(), $field['value']->pluck($connected_entity_entry->getKeyName(), $connected_entity_entry->getKeyName())->toArray())) || ( old( $field["name"] ) && in_array($connected_entity_entry->getKey(), old( $field["name"])) ) )
                        selected
                        @endif
                >{{ $connected_entity_entry->{$field['attribute']} }}</option>
            @endforeach
        @endif
    </select>

    @if (isset($field['hint']))
        <p class="help-block">{!! $field['hint'] !!}</p>
    @endif
</div>
