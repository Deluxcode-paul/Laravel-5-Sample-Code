@extends('user.profile.template', [
    'profile_class' => 'profile-articles'
])

@section('profile-breadcrumbs')
    {!! Breadcrumbs::render('user.my-articles') !!}
@endsection

@section('profile-section-title')
    @lang('user/profile.sections.my_articles')
@endsection

@section('profile-content')

    <script>
        var trans = {!! json_encode($labels) !!},
            json = {!! $results !!};

        json.manageUrl = '{{ url('/admin/articles') }}';
        json.emptyMsg = trans.empty.my_articles;
    </script>

    <div id="vue-app">
        <router-view></router-view>
    </div>

@endsection