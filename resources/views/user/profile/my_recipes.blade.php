@extends('user.profile.template', [
    'profile_class' => 'profile-recipes'
])

@section('profile-breadcrumbs')
    {!! Breadcrumbs::render('user.my-recipes') !!}
@endsection

@section('profile-section-title')
    @lang('user/profile.sections.my_recipes')
@endsection

@section('profile-content')

    <script>
        var trans = {!! json_encode($labels) !!},
            json = {!! $results !!};

        json.manageUrl = '{{ url('/admin/recipes') }}';
        json.emptyMsg = trans.empty.my_recipes;
    </script>

    <div id="vue-app">
        <router-view></router-view>
    </div>

@endsection