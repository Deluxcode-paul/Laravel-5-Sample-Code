<!DOCTYPE html>
<html class="no-js" lang="en">
<head>
    <script>(function(e,t,n){var r=e.querySelectorAll("html")[0];r.className=r.className.replace(/(^|\s)no-js(\s|$)/,"$1js$2")})(document,window,0);</script>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width,initial-scale=1.0,maximum-scale=1.0">

    @stack('header_meta')

    <script>
        window.Laravel = window.Laravel || {};
        window.Laravel.csrfToken = '{{ csrf_token() }}';
    </script>

    @include('partials.favicon')

    @include('partials.custom_fonts')

    <link href="//fonts.googleapis.com/css?family=Dancing+Script" rel="stylesheet">

    @stack('header_css')

    @stack('header_js')

    @if (env('APP_ENV') == 'local')
        <link href="{{ URL('/css/general.css') }}" rel="stylesheet">
    @else
        <link href="{{ URL('/') }}{{ elixir('css/general.css') }}" rel="stylesheet">
    @endif

    <title>
        @if(View::hasSection('title'))
            @yield('title') | @lang('global.site_name')
        @else
            @lang('global.site_name')
        @endif
    </title>
    @yield('bfm-share-tags')
</head>
<body class="{{ $page_class or 'page-without-class' }}">

    @yield('base')

    {!! Assets::group('frontend')->js() !!}
    {!! Assets::group('frontend')->css() !!}

    @yield('inline_script')

    @stack('footer_js')

    @if (Session::has('js-flash-message'))
        <script type="text/javascript">
            Front.showMessage('{{ Session::get('js-flash-message') }}');
        </script>
    @endif
    {{-- @include('partials.global_messages') --}}

</body>
</html>
