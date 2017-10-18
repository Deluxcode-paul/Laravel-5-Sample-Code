@section('inline_script')
    @parent
    <script>
        Front.routes.report_abuse = '{{ route('user.profile.activity.report-abuse') }}';
        Front.routes.vote = '{{ route('user.profile.activity.vote') }}';
        Front.translations.report_abuse_error = '{{ trans('user/profile.js_messages.report_abuse_error') }}';
        Front.translations.vote_error = '{{ trans('user/profile.js_messages.vote_error') }}';
    </script>
@endsection