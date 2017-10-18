@if($form->has_recaptcha && !empty('bfm-forms.recaptchaKey'))
    <script src="//www.google.com/recaptcha/api.js" async defer></script>
@endif

<form action="{{ $form->handlerUrl }}"
      method="post"
      @unless(empty($form->elem_id)) id="{{ $form->elem_id }}" @endunless
      class="form-grey form-contact j-contact-form"
      {{ $form->attributes }}>
    @if(count($errors))
        <ul>
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    @endif
    {{ csrf_field() }}
    <input type="hidden" name="slug" value="{{ $form->slug }}">
    @foreach($fields as $index => $field)
        @if($field->isFieldsetOpeningTagNeeded($fields, $index))
            <fieldset name="{{ $field->fieldset }}">
        @endif
        <div @unless(empty($field->wrapper_id)) id="{{ $field->wrapper_id }}" @endunless class="form-row">
            <div class="form-item">
                @unless(empty($field->label))
                    <label class="form-label" for="{{ $field->name }}">{{ $field->label }}</label>
                @endunless
                {!! $field->render() !!}
            </div>
        </div>
        @if($field->isFieldsetClosingTagNeeded($fields, $index))
            </fieldset>
        @endif
    @endforeach
    @if($form->has_recaptcha && !empty(config('bfm-forms.recaptchaKey')))
        <div class="g-recaptcha" data-sitekey="{{ config('bfm-forms.recaptchaKey') }}"></div>
    @endif
    <div class="form-actions">
        <button class="btn is-purple is-large uppercase" type="submit">
            @lang('bfm-forms::main.buttons.submit')
        </button>
    </div>
</form>
@section('inline_script')
    @parent
    @if(Session::has('msg'))
        <script>
            $(document).ready(function() {
               Front.showMessage('{{ session('msg') }}')
            });
        </script>
    @endif
@endsection