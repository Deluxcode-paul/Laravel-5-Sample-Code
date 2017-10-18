<style>
    ul.bfm-share {
        list-style: none;
    }
    ul.bfm-share li {
        display: inline-block;
        width: 20px;
        height: 20px;
    }
</style>
<ul @if(isset($options['id']))id="{{ $options['id'] }}" @endif
    class="bfm-share {{ isset($options['class']) ? $options['class'] : '' }}">
    @foreach($socials as $social)
        <li>
            @include($social['view'], compact('social'))
        </li>
    @endforeach
</ul>
