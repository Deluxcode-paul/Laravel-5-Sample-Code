<nav class="user-nav j-subnav">
    <span class="user-nav__welcome uppercase ellipsis nowrap">
        <img src="{{ $currentUser->getImage('user_avatar') }}" alt="{{ $currentUser->fullName }}" />
        @lang('common/header.menu.user.welcome_message'), {{ $currentUser->first_name }}
    </span>
    <div class="submenu">
        <ul>
            @role($roles['admin'])
            <li><a href="{{ url('admin') }}">@lang('common/header.menu.user.admin')</a></li>
            @endrole
            <li>
                {{ KosherHelper::link([
                    route('user.profile.activity.recipe-questions'),
                    route('user.profile.activity.recipe-reviews'),
                    route('user.profile.activity.article-comments'),
                    route('user.profile.activity.community-questions'),
                ], trans('common/header.menu.user.activity')) }}
            </li>
            <li>{{ KosherHelper::link($currentUser->profileUrl, trans('common/header.menu.user.my_account')) }}</li>
            <li>{{ KosherHelper::link(route('user.profile.recipe-box.view'), trans('common/header.menu.user.recipe_box')) }}</li>
            <li>{{ KosherHelper::link(route('user.profile.shopping-lists.view'), trans('common/header.menu.user.shopping_lists')) }}</li>

            @hasanyrole($roles['chefs'])
            <li>{{ KosherHelper::link(route('user.profile.my-recipes.view'), trans('common/header.menu.user.my_recipes')) }}</li>
            @endhasanyrole

            @role($roles['professional_chef'])
            <li>{{ KosherHelper::link(route('user.profile.my-articles.view'), trans('common/header.menu.user.my_articles')) }}</li>
            @endrole

            <li><a href="{{ url('logout') }}">@lang('common/header.menu.user.logout')</a></li>
        </ul>
    </div>
</nav>