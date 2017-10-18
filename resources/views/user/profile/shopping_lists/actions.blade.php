<a href="#" class="link js-select-recipe-button">@lang('user/profile.buttons.select_all')</a>
<ul class="profile__actions">
    <li>
        <button class="link-gold js-pdf-recipe-button">
            @include('partials.icons.icon-pdf')
            <span>
                @lang('user/profile.buttons.pdf')
            </span>
        </button>
    </li>
    <li>
        <button class="link-gold js-email-recipe-button">
            @include('partials.icons.icon-letter')
            <span>
                @lang('user/profile.buttons.email')
            </span>
        </button>
    </li>
    <li class="only-desktop">
        <button class="link-gold js-print-recipe-button">
            @include('partials.icons.icon-print')
            <span>
                @lang('user/profile.buttons.print')
            </span>
        </button>
    </li>
    <li>
        <button class="link-gold js-delete-recipe-button">
            @include('partials.icons.icon-delete')
            <span>
                @lang('user/profile.buttons.delete')
            </span>
        </button>
    </li>
</ul>
