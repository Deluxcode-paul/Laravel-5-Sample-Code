<nav class="footer-nav j-footerNav">
    <button class="footer-nav__btn j-open-footerNav">@lang('common/footer.menu.links')</button>
    <ul>
        <li>{{ KosherHelper::link(route('recipes.category'), trans('common/footer.menu.recipes')) }}</li>
        <li>{{ KosherHelper::link(route('lifestyle'), trans('common/footer.menu.lifestyle')) }}</li>
        <li>{{ KosherHelper::link(route('watch'), trans('common/footer.menu.watch')) }}</li>
        <li>{{ KosherHelper::link(url(config('kosher.links.learn')), trans('common/footer.menu.learn')) }}</li>
        <li>{{ KosherHelper::link(route('community'), trans('common/footer.menu.community')) }}</li>
        <li>{{ KosherHelper::link(url(config('kosher.links.about')), trans('common/footer.menu.about')) }}</li>
        <li>{{ KosherHelper::link(route('contact'), trans('common/footer.menu.contact')) }}</li>
    </ul>
</nav>