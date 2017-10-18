@backpackAssets('pikaday')
@backpackAssets('crud/filters/date_range.js')

<div class="col-md-3 col-filter-dates">
    <div class="form-group">
        <label>{!! $filter['label'] !!}</label>
        <div class="input-group">
            <div class="input-group-addon">@lang('crud.helpers.from')</div>
            <input
                    type="text"
                    name="{{ $filter['name'] }}[from]"
                    value="{{ isset($filter['default']['from']) ? $filter['default']['from'] : '' }}"
                    class="form-control date-picker-start"
                    data-name="{{ $filter['name'] }}"
            />
        </div>
    </div>
    <div class="form-group">
        <label>&nbsp;</label>
        <div class="input-group">
            <div class="input-group-addon">@lang('crud.helpers.to')</div>
            <input
                    type="text"
                    name="{{ $filter['name'] }}[to]"
                    value="{{ isset($filter['default']['to']) ? $filter['default']['to'] : '' }}"
                    class="form-control date-picker-end"
                    data-name="{{ $filter['name'] }}"
            />
        </div>
    </div>
    <div class="clearfix"></div>
</div>