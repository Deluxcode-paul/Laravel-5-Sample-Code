@extends('layouts.mail')

@section('mail-title')
    {{ trans('share.mail_to_email_title') }}
@endsection

@section('content')
    {{ $url }}
@endsection
