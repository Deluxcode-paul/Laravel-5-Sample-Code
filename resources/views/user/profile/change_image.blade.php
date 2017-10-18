<a href="javascript:;" class="link">(@lang('user/profile.buttons.change_image'))</a>

<div>
    {{ Form::open([
        'url' => route('user.profile.account.save.image'),
        'method' => 'POST',
        'files' => true
    ]) }}
    {{ Form::file('image') }}
    <button type="submit" class="btn btn-primary">
        @lang('user/profile.buttons.save')
    </button>
    {{ Form::close() }}
</div>