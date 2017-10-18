@extends('user.profile.activity.wrapper', [
    'profile_class' => 'profile-activity'
])

@section('title', trans('titles.profile.activity.article_comments'))

@section('profile-breadcrumbs')
    {!! Breadcrumbs::render('user.activity.article-comments') !!}
@endsection

@section('profile-section-title')
    @lang('user/profile.sections.activity')
@endsection

@section('profile-content')
    @parent
    <script>
        json.emptyMsg = trans.activity.empty_article_comments;
    </script>
@endsection