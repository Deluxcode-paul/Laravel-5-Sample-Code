<!DOCTYPE html>
<html lang="en">
<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1.0,maximum-scale=1.0">

    @include('partials.custom_fonts')

    @if (env('APP_ENV') == 'local')
        <link href="{{ URL('/css/pdf.css') }}" rel="stylesheet">
    @else
        <link href="{{ URL('/') }}{{ elixir('css/pdf.css') }}" rel="stylesheet">
    @endif

    <title>@lang('global.site_name')</title>

</head>
<body>
    <div class="pdf-wrapper">
        <main class="pdf-main">
            @yield('content')
        </main>
    </div>
</body>
</html>
