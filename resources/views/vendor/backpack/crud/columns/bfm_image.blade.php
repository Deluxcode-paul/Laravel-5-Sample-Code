<td>
    @unless (empty($entry->{$column['name']}))
    <img src="{{ $entry->getImage('backpack.thumb') }}" alt="{{ $entry->{$column['name']} }}" />
    @endunless
</td>