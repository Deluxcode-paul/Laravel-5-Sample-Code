<a href="http://pinterest.com/pin/create/button/?url={{ urlencode($url ?? Request::url()) }}&media={{ $params['media'] }}"
   class="bfm-share__pinterest"
   target="_blank">
    @include($social['icon_view'])
</a>
