<td>
    @unless (empty($entry->{$column['name']}))
    <i class="fa fa-external-link"></i> <a href="{{ $entry->{$column['name']} }}" target="_blank">{{ $entry->{$column['name']} }}</a>
    @endunless
</td>