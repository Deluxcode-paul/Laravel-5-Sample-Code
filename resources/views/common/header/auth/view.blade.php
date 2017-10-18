<div class="main-nav__auth">
    @if (Auth::check())
        @include('common.header.auth.user')
    @else
        @include('common.header.auth.guest')
    @endif
</div>