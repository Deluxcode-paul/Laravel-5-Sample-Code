
    <a
            href="#"
            class="js-mail-to"
            data-error=" @lang('share.mail_to_error') ">

        @lang('share.mail_to')
    </a>

    <div class="form js-mail-to-popup" style="display:none;">
        {{ Form::open(
                ['url' => route('share.mail-to'),
                'method'=>'POST',
                'files'=>true,
                'id'=>'js-mail-to-form',
                'class' => 'form js-mail-to-form'
            ]) }}
        {{
            Form::text('recipients_mail', '',
                        [
                        'placeholder' => trans('share.mail_to_placeholder'),
                        'maxlength' => 50
                        ]
            )
        }}

        {{
            Form::hidden('url', Request::url() )
        }}

        {{ Form::button(
                     trans('share.mail_to_cancel'),
                     [
                         'id' => 'js-reset-mail-to',
                         'class' => 'btn-cancel js-mail-to-cancel'
                     ]
                 )
        }}

        {{ Form::button(
                trans('share.mail_to_submit'),
                    [
                        'type' => 'submit',
                        'class' => 'btn-submit js-mail-to-submit'
                    ]
                )
        }}

        {{ Form::close() }}
</div>

