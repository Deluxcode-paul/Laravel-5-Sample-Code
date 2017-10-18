<div class="main-nav__menu j-nav">
    <button class="main-nav__btn j-open-nav"><span></span></button>
    <ul>
        <li class="has-sub">
            {{ KosherHelper::link(route('recipes.category'), trans('common/header.menu.recipes'), [
                'class' => 'ajax',
                'data-ajax-url' => '/ajax/megamenu'
            ]) }}
            <div id="js-megamenu" class="megamenu js-megamenu"></div>
        </li>
        <li>{{ KosherHelper::link(route('lifestyle'), trans('common/header.menu.lifestyle')) }}</li>
        <li>{{ KosherHelper::link(route('watch'), trans('common/header.menu.watch')) }}</li>
        <li class="has-sub j-subnav">
            {{ KosherHelper::link(url(config('kosher.links.learn')), trans('common/header.menu.learn')) }}
            <div class="submenu">
                <ul>
                    <li>{{ KosherHelper::link(url(config('kosher.links.what_is_kosher')), trans('common/header.menu.what_is_kosher')) }}</li>
                    <li>{{ KosherHelper::link(url(config('kosher.links.new_to_kosher')), trans('common/header.menu.new_to_kosher')) }}</li>
                </ul>
            </div>
        </li>
        <li>{{ KosherHelper::link(route('community'), trans('common/header.menu.community')) }}</li>
    </ul>
</div>