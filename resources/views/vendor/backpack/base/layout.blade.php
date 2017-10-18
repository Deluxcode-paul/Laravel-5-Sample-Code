<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}"/>
    <title>
        @if (isset($title))
            {{ $title }} |
        @endif
        {{ config('backpack.base.project_name') . ' Admin Panel' }}
    </title>
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

    {!! Assets::group('adminlte')->css() !!}
    {!! Assets::group('backpack')->css() !!}
    {!! Assets::group('barryvdh')->css() !!}

    @yield('cms-styles')

    <!--[if lt IE 9]>
    {!! Assets::group('ie9')->css() !!}
    {!! Assets::group('ie9')->js() !!}
    <![endif]-->
</head>
<body class="hold-transition {{ config('backpack.base.skin') }} sidebar-mini">

<div class="wrapper">
    <header class="main-header">
        <a href="{{ url('') }}" class="logo">
            <span class="logo-mini">{!! config('backpack.base.logo_mini') !!}</span>
            <span class="logo-lg">{!! config('backpack.base.logo_lg') !!}</span>
        </a>
        <nav class="navbar navbar-static-top" role="navigation">
            <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
                <span class="sr-only">{{ trans('backpack::base.toggle_navigation') }}</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </a>
            @include('backpack::inc.menu')
        </nav>
    </header>

    @include('backpack::inc.sidebar')

    <div class="content-wrapper">
        @yield('header')
        <section class="content">
            @yield('content')
        </section>
    </div>
    <footer class="main-footer">
        {{ trans('backpack::base.handcrafted_by') }}
        <a target="_blank" href="{{ config('backpack.base.developer_link') }}">
            {{ config('backpack.base.developer_name') }}
        </a>.
    </footer>
</div>

@include('backpack::inc.js_variables')

{!! Assets::group('adminlte')->js() !!}
{!! Assets::group('backpack')->js() !!}
{!! Assets::group('barryvdh')->js() !!}

@include('backpack::inc.alerts')
@yield('cms-scripts')

</body>
</html>
