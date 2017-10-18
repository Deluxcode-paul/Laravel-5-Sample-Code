<aside class="profile__aside aside">
    <div class="aside__avatar ajax-section">
        {{ Form::open([
            'url' => route('user.profile.account.save.image'),
            'method' => 'POST',
            'class' => 'form js-form form-avatar',
            'id' => 'js-form-avatar',
            'files' => true
        ]) }}
            <div class="photo">
                <img class="img-preview" src="{{ $currentUser->getImage('user_account') }}" />
            </div>
            <div class="name">{{ $currentUser->fullName }}</div>
            <label>
                {{ Form::file('image', [
                    'autocomplete' => 'off',
                    'class' => 'inputfile js-inputfile',
                    'accept' => config('kosher.validation.img.accept'),
                    'data-max-size' => config('kosher.validation.img.size')
                ]) }}
                <span class="link">(@lang('user/profile.buttons.change_image'))</span>
            </label>
            <div class="form-actions">
                <button type="submit" class="btn is-wide btn-submit">
                    @lang('user/profile.buttons.save')
                </button>
            </div>
        {{ Form::close() }}
        <div class="preloader">
            <div class="preloader__icon"></div>
        </div>
    </div>
    <nav class="aside__navigation">
        <ul>
            <li @if (in_array($currentRoute,
            array(
            'user.profile.activity.recipe-questions',
            'user.profile.activity.recipe-reviews',
            'user.profile.activity.article-comments',
            'user.profile.activity.community-questions',
            ))) class="active" @endif>
                <a href="{{ route('user.profile.activity.recipe-questions') }}">
                    <span>
                        @include('partials.icons.icon-activity')
                    </span>
                    @lang('user/profile.menu.activity')
                </a>
            </li>
            <li @if ($currentRoute == 'user.profile.account.view') class="active" @endif><a href="{{ route('user.profile.account.view') }}">
                <span>
                    @include('partials.icons.icon-account')
                </span>
                @lang('user/profile.menu.account_info')
            </a></li>
            <li @if ($currentRoute == 'user.profile.recipe-box.view') class="active" @endif><a href="{{ route('user.profile.recipe-box.view') }}">
                <span>
                    @include('partials.icons.icon-dish')
                </span>
                @lang('user/profile.menu.recipe_box')
            </a></li>
            <li @if ($currentRoute == 'user.profile.shopping-lists.view') class="active" @endif><a href="{{ route('user.profile.shopping-lists.view') }}">
                <span>
                    @include('partials.icons.icon-shopping')
                </span>
                @lang('user/profile.menu.shopping_lists')
            </a></li>
            @hasanyrole($roles['chefs'])
                <li @if ($currentRoute == 'user.profile.my-recipes.view') class="active" @endif><a href="{{ route('user.profile.my-recipes.view') }}">
                    <span>
                        @include('partials.icons.icon-recipe')
                    </span>
                    @lang('user/profile.menu.recipes')
                </a></li>
            @endhasanyrole
            @role($roles['professional_chef'])
                <li @if ($currentRoute == 'user.profile.my-articles.view') class="active" @endif><a href="{{ route('user.profile.my-articles.view') }}">
                    <span>
                        @include('partials.icons.icon-article')
                    </span>
                    @lang('user/profile.menu.articles')
                </a></li>
            @endrole
        </ul>
    </nav>
</aside>