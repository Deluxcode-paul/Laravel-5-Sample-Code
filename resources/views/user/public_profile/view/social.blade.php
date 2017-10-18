<div class="chef__social">
    @if ($user->facebook)
        <a href="{{ $user->facebook }}" class="link" target="_blank">
            @include('partials.icons.icon-facebook')
        </a>
    @endif
    @if ($user->instagram)
        <a href="{{ $user->instagram }}" class="link" target="_blank">
            @include('partials.icons.icon-instagram')
        </a>
    @endif
    @if ($user->pinterest)
        <a href="{{ $user->pinterest }}" class="link" target="_blank">
            @include('partials.icons.icon-pinterest')
        </a>
    @endif
    @if ($user->youtube)
        <a href="{{ $user->youtube }}" class="link" target="_blank">
            @include('partials.icons.icon-youtube')
        </a>
    @endif
    @if ($user->twitter)
        <a href="{{ $user->twitter }}" class="link" target="_blank">
            @include('partials.icons.icon-twitter')
        </a>
    @endif
    @if ($user->website)
        <a href="{{ $user->website }}" class="link" target="_blank">
            @include('partials.icons.icon-link')
        </a>
    @endif
</div>