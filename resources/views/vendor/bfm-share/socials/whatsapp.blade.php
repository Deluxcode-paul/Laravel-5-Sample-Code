<a href="whatsapp://send?text={{ $social['subject'] }} {{ $url ?? Request::url() }}">
    @include($social['icon_view'])
</a>