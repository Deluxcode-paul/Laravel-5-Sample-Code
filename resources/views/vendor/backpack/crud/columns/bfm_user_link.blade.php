<td>
    @unless (empty($entry->{$column['entity']}()->getResults()))
        @if ($entry->{$column['entity']}->isAdmin() || $entry->{$column['entity']}->isRegularUser())
            <a href="{{ url('admin/users/' . $entry->{$column['name']} . '/edit') }}">
                {{ $entry->{$column['entity']}()->getResults()->{$column['attribute']} }}
            </a>
        @elseif ($entry->{$column['entity']}->isTopChef())
            <a href="{{ url('admin/top-chefs/' . $entry->{$column['name']} . '/edit') }}">
                {{ $entry->{$column['entity']}()->getResults()->{$column['attribute']} }}
            </a>
        @elseif ($entry->{$column['entity']}->isCommunityChef())
            <a href="{{ url('admin/users/' . $entry->{$column['name']} . '/edit') }}">
                {{ $entry->{$column['entity']}()->getResults()->{$column['attribute']} }}
            </a>
        @endif
    @endunless
</td>