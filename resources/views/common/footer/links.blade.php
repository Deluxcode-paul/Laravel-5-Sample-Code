<nav class="footer-links">
    <ul>
        <li><span>@lang('common/footer.copyright'), {{ date('Y') }}</span></li>
        <li>{{ KosherHelper::link(url(config('kosher.links.terms')), trans('common/footer.links.terms')) }}</li>
        <li>{{ KosherHelper::link(url(config('kosher.links.privacy')), trans('common/footer.links.privacy')) }}</li>
    </ul>
</nav>
