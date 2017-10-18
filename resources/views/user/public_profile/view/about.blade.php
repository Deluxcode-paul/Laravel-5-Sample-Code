<img class="chef__photo" src="{{ $user->getImage('user_public_profile') }}" />

<div class="chef__about">
    <div class="chef__top">
        @if (empty($currentUser))
            <div class="actions">
                <a class="btn" href="{{ route('contact') }}?inquiry_type=claim-profile">@lang('user/profile.buttons.claim_profile')</a>
            </div>
        @endif
        @if (!empty($currentUser) && ($currentUser->id == $user->id))
            <div class="actions">
                <a class="btn" href="{{ route('user.profile.account.view') }}">@lang('user/profile.buttons.edit_account')</a>
                @hasanyrole($roles['chefs'])
                    <a class="btn" href="{{ url('/admin/recipes') }}">@lang('user/profile.buttons.add_recipe')</a>
                @endhasanyrole
                @role($roles['professional_chef'])
                    <a class="btn" href="{{ url('/admin/articles') }}">@lang('user/profile.buttons.add_article')</a>
                @endrole
            </div>
        @endif
        <div class="info">
            @if ($user->location)
                <span>{{ $user->location }}</span>
            @endif
            @if ($user->place_of_work)
                @if ($user->location)
                    <span> | </span>
                @endif
                <span>{{ $user->place_of_work }}</span>
            @endif
        </div>

        @if ($user->status)
            <div class="quote">
                "{{ $user->status }}"
            </div>
        @endif
    </div>

    @include('partials.separator')

    @if ($user->bio)
        <div class="desc j-desc">
            {!! nl2br(e($user->bio)) !!}
            <button class="link j-more">@lang('user/profile.buttons.read_more')</button>
        </div>
    @endif
</div>