<section class="aside__section">
    <h2 class="title">@lang('community.headings.popular_tags')</h2>
    <ul class="popular-tags">
        @foreach ($popularTags as $tag)
            <li><a href="{{ $tag->communitySearchUrl }}">{{ $tag->title }}</a></li>
        @endforeach
    </ul>
</section>