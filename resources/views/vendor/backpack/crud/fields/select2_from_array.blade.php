@backpackAssets('select2')
@backpackAssets('crud/fields/select2_from_array.js')

<div @include('crud::inc.field_wrapper_attributes') >
    <label>{!! $field['label'] !!}</label>
    <select
            name="{{ $field['name'] }}"
            @include('crud::inc.field_attributes', ['default_class' =>  'form-control select2-array'])
    >

        @if (isset($field['attributes']['placeholder']))
            <option></option>
        @elseif (isset($field['allows_null']) && $field['allows_null']==true)
            <option value="">-</option>
        @endif

        @if (count($field['options']))
            @foreach ($field['options'] as $key => $value)
                <option value="{{ $key }}"
                        @if ((isset($field['value']) && $key==$field['value']) || ( ! is_null( old($field['name']) ) && old($field['name']) == $key) )
                        selected
                        @endif
                >{{ $value }}</option>
            @endforeach
        @endif
    </select>

    @if (isset($field['hint']))
        <p class="help-block">{!! $field['hint'] !!}</p>
    @endif
</div>
