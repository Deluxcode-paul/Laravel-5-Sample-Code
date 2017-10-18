@extends('backpack::layout')

@adminlteAssets('jqueryUI')
@backpackAssets('elfinder')
@barryvdhAssets('elfinder')
@barryvdhAssets('elfinder/elfinder.js')

@section('header')
    <section class="content-header">
        <h1>File manager</h1>
        <ol class="breadcrumb">
            <li><a href="{{ url('admin') }}">Admin</a></li>
            <li class="active">File Manager</li>
        </ol>
    </section>
@endsection

@section('content')
    <div id="elfinder"></div>
@endsection
