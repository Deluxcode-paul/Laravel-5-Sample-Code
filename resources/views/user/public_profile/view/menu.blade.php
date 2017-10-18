@if ($user->recipes->count() > 0
    || $user->articles()->published()->count() > 0
    || $videos->count() > 0
    || $articleComments->count()
    || $communityQuestions->count()
    || $recipeQuestions->total()
    || $recipeReviews->total()
)
    <ul class="chef__nav tabset uppercase">
        @if ($user->hasAnyRole($roles['chefs']) && $user->recipes->count() > 0)
            <li><a href="#recipes">@lang('user/profile.public_menu.recipes')</a></li>
        @endif
        @if ($user->hasRole($roles['professional_chef']) && $user->articles()->published()->count() > 0)
            <li><a href="#articles">@lang('user/profile.public_menu.articles')</a></li>
        @endif
        @if ($user->hasAnyRole($roles['chefs']) && $videos->count() > 0)
            <li><a href="#videos">@lang('user/profile.public_menu.videos')</a></li>
        @endif
        @if ($user->hasAnyRole($roles['chefs'])
            && ($articleComments->count()
                || $communityQuestions->count()
                || $recipeQuestions->total()
                || $recipeReviews->total()))
            <li><a href="#comments">@lang('user/profile.public_menu.comments')</a></li>
        @endif
    </ul>
@endif