@extends('user.profile.template', [
    'profile_class' => 'profile-activity'
])

@section('profile-content')

    <script>
        var trans = {!! json_encode($labels) !!},
            json = {!! $results !!};

        json.nav = [
            {
                url: '{{ route('user.profile.activity.recipe-questions') }}',
                title: '@lang('user/profile.activity.recipe_questions')'
            },
            {
                url: '{{ route('user.profile.activity.recipe-reviews') }}',
                title: '@lang('user/profile.activity.recipe_reviews')'
            },
            {
                url: '{{ route('user.profile.activity.article-comments') }}',
                title: '@lang('user/profile.activity.article_comments')'
            },
            {
                url: '{{ route('user.profile.activity.community-questions') }}',
                title: '@lang('user/profile.activity.community_questions')'
            }
        ];
    </script>

    <div id="vue-app">
        <router-view></router-view>
    </div>

@endsection

@include('user.profile.activity.blocks.inline_script')