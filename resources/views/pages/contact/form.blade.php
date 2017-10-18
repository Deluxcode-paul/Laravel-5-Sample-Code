{{ Form::open([
    'route' => 'contact.submit',
    'method' => 'post',
    'class' => 'form-grey form-contact j-contact-form',
    'novalidate'
]) }}
    <div class="form-row">
        <div class="form-item">
            <label class="form-label" for="inquiry_type">@lang('pages/contact.form.inquiry_type')</label>
            <div class="form-input is-select">
                {{ Form::select(
                    'inquiry_type',
                    $inquiryTypes,
                    old('inquiry_type') ? old('inquiry_type') : isset($values['inquiry_type']) ? $values['inquiry_type'] : '',
                    [
                        'placeholder' => trans('pages/contact.form.placeholders.inquiry_type'),
                        'required'
                    ]
                ) }}
            </div>
            @include('partials.separator')
        </div>
    </div>

    <div class="form-row">
        <div class="form-item">
            <label class="form-label" for="name">@lang('pages/contact.form.name')</label>
            <div class="form-input">
                {{ Form::text('name', old('name') ? old('name') : isset($values['name']) ? $values['name'] : '', [
                    'placeholder' => trans('pages/contact.form.placeholders.name'),
                    'maxlength' => 255,
                    'required'
                ]) }}
            </div>
        </div>
    </div>

    <div class="form-row">
        <div class="form-item">
            <label class="form-label" for="email">@lang('pages/contact.form.email')</label>
            <div class="form-input">
                {{ Form::email('email', old('email') ? old('email') : isset($values['email']) ? $values['email'] : '', [
                    'placeholder' => trans('pages/contact.form.placeholders.email'),
                    'maxlength' => 255,
                    'required'
                ]) }}
            </div>
        </div>
    </div>

    <div class="form-row">
        <div class="form-item">
            <label class="form-label" for="message">@lang('pages/contact.form.message')</label>
            <div class="form-input">
                {{ Form::textarea('message', old('message') ? old('message') : isset($values['message']) ? $values['message'] : '', [
                    'placeholder' => trans('pages/contact.form.placeholders.message'),
                    'required'
                ]) }}
            </div>
        </div>
    </div>

    <div class="form-actions">
        <button class="btn is-purple is-large uppercase" type="submit">
            @lang('pages/contact.form.submit')
        </button>
    </div>
{{ Form::close() }}

@section('inline_script')
    @parent
    @if (Session::has('msg'))
        <script>
            $(document).ready(function() {
                Front.showMessage('{{ session('msg') }}', 'success')
            });
        </script>
    @endif
@endsection