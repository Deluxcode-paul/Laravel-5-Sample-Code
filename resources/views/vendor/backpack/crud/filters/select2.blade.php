@backpackAssets('select2')
@backpackAssets('crud/filters/select2.js')

<div class="{{ isset($filter['size']) ? $filter['size'] : 'col-md-2' }}">
    <div class="form-group">
        <label>{!! $filter['label'] !!}</label>
        <select name="{{ $filter['name'] }}" class="form-control select2">
            <option value="">{{ $filter['placeholder'] }}</option>
            @foreach ($filter['options'] as $value => $label)
                <option value="{{ $value }}" @if (isset($filter['default']) && $value == $filter['default']) selected @endif >
                    {{ $label }}
                </option>
            @endforeach
        </select>
    </div>
</div>