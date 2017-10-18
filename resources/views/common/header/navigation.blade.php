<nav class="main-nav is-mobile">
    <div class="main-nav__wrap">
        @include('common.header.search.view')
    </div>
</nav>
<nav class="main-nav j-nav">
    <button class="main-nav__btn j-open-nav"><span></span></button>
    <div class="main-nav__wrap">
        @include('common.header.menu.view')
        @include('common.header.search.view')
        @include('common.header.auth.view')
    </div>
</nav>
