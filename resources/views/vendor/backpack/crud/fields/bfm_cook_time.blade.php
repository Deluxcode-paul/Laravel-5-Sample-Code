@backpackAssets('select2')
@backpackAssets('crud/fields/select2.js')

<div class="form-group col-md-12 cook-time-wrapper">
    <label>{!! $field['label'] !!}</label>
    <div class="clearfix"></div>
    <div class="col-sm-2 input-group">
        <input
                type="number"
                name="{{ $field['name'] }}_hours"
                value="{{ old($field['name'].'_hours') ? old($field['name'].'_hours') : (empty($entry) ? '' : $entry->getCookTimeHours()) }}"
                @include('crud::inc.field_attributes')
        />
        <div class="input-group-addon"> @lang('crud.helpers.hours')</div>
    </div>
    <div class="col-sm-2 input-group">
        <input
                type="number"
                name="{{ $field['name'] }}_minutes"
                value="{{ old($field['name'].'_minutes') ? old($field['name'].'_minutes') : (empty($entry) ? '' : $entry->getCookTimeMinutes()) }}"
                @include('crud::inc.field_attributes')
        />
        <div class="input-group-addon"> @lang('crud.helpers.minutes')</div>
    </div>
    @if (isset($field['hint']))
        <div class="help-block">{!! $field['hint'] !!}</div>
    @endif
</div>
