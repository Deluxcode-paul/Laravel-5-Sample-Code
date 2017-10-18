<li>
    <a href="{{ route('crud.forms.index') }}">
        <i class="fa fa-tasks"></i>
        <span>
            @if(config('bfm-forms.devMode'))
                @lang('bfm-forms::main.menu_title.devMode')
            @else
                @lang('bfm-forms::main.menu_title.prodMode')
            @endif
        </span>
    </a>
</li>
