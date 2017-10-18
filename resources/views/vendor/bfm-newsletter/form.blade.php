@push('footer_js')
    <script src="{{ URL::to('vendor/bfm-newsletter/js/main.js') }}"></script>
    <script src="{{ URL::to('vendor/bfm-newsletter/js/init.js') }}"></script>
@endpush

{{ Form::open([
    'route' => 'bfm-newsletter.subscribe',
    'id' => 'js-newsletter',
    'class' => 'form js-form form-newsletter',
    'novalidate',
    'role' => 'form'
    ]) }}
    <div class="form-row">
        <div class="form-item{{ isset($errors) && $errors->has('email') ? ' has-error' : '' }}">
            <div class="form-input">
                {{ Form::email('email', old('email'), [
                    'id' => 'email',
                    'placeholder' => trans('common.newsletter.email'),
                    'maxlength' => 255,
                    'required',
                    'class' => 'form-control',
                ]) }}
            </div>
        </div>
    </div>
    <button type="submit" class="btn-submit">@include('partials.icons.icon-letter')</button>
{{ Form::close() }}
