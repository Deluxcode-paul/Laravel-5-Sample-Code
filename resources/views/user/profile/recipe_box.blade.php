@extends('user.profile.template', [
    'profile_class' => 'profile-box'
])

@section('title', trans('titles.profile.recipe_box'))

@section('profile-breadcrumbs')
    {!! Breadcrumbs::render('user.recipe-box') !!}
@endsection

@section('profile-section-title')
    @lang('user/profile.sections.recipe_box')
@endsection

@section('profile-content')

    <script>
        var trans = {!! json_encode($labels) !!},
            json = {!! $results !!};

        json.emptyMsg = trans.empty.recipe_box;

    </script>

    <div id="vue-app">
        <router-view></router-view>
    </div>

@endsection