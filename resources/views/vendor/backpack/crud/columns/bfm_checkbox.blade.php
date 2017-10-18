<td>
    <a href="{{ route('backend.ajax.checkbox') }}" class="bfm-checkbox"
       data-field="{{ $column['name'] }}"
       data-value="{{ $entry->{$column['name']} }}"
       data-id="{{ $entry->id }}"
       data-model="{{ get_class($entry) }}"
    >
        <i class="fa {{ empty($entry->{$column['name']}) ? 'fa-square-o' : 'fa-check-square-o' }}"></i>
    </a>
</td>