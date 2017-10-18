@extends('user.profile.activity.wrapper', [
    'profile_class' => 'profile-activity'
])

@section('title', trans('titles.profile.activity.recipe_questions'))

@section('profile-breadcrumbs')
    {!! Breadcrumbs::render('user.activity.recipe-questions') !!}
@endsection

@section('profile-section-title')
    @lang('user/profile.sections.activity')
@endsection

@section('profile-content')
    @parent
    <script>
        json.emptyMsg = trans.activity.empty_recipe_questions;
    </script>
@endsection