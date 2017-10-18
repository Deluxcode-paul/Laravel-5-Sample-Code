<div class="{{ isset($filter['size']) ? $filter['size'] : 'col-md-2' }}">
    <div class="form-group">
        <label>{!! $filter['label'] !!}</label>
        <input
                class="form-control"
                name="{{ $filter['name'] }}"
                value="{{ isset($filter['default']) ? $filter['default'] : '' }}"
                type="text"
        />
    </div>
</div>