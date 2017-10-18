@if (!isset($type))
    <div class="separator"></div>
@elseif ($type == 'icon')
    <div class="separator with-icon">
        <span class="holder">
            <span></span>
            @include('partials.icons.icon-separator')
            <span></span>
        </span>
    </div>
@endif