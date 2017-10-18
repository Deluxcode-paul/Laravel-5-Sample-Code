@backpackAssets('colorbox')
@backpackAssets('crud/fields/browse.js')

<div @include('crud::inc.field_wrapper_attributes') >
    <label>{!! $field['label'] !!}</label>
    <input
            type="text"
            id="{{ $field['name'] }}-filemanager"
            name="{{ $field['name'] }}"
            value="{{ old($field['name']) ? old($field['name']) : (isset($field['value']) ? $field['value'] : (isset($field['default']) ? $field['default'] : '' )) }}"
            @include('crud::inc.field_attributes')
            @if(!isset($field['readonly']) || $field['readonly']) readonly @endif
    >

    <div class="btn-group" role="group" aria-label="..." style="margin-top: 3px;">
        <button type="button" data-inputid="{{ $field['name'] }}-filemanager" class="btn btn-default popup_selector">
            <i class="fa fa-cloud-upload"></i> {{ trans('backpack::crud.browse_uploads') }}</button>
        <button type="button" data-inputid="{{ $field['name'] }}-filemanager"
                class="btn btn-default clear_elfinder_picker">
            <i class="fa fa-eraser"></i> {{ trans('backpack::crud.clear') }}</button>
    </div>

    @if (isset($field['hint']))
        <p class="help-block">{!! $field['hint'] !!}</p>
    @endif
</div>
