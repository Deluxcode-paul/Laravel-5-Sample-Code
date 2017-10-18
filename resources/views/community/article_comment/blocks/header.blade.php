@include('community.blocks.header_buttons')

<div class="community-details">
    <div class="community-details__img">
        <img src="{{ $item->article->getImage('community_details') }}" alt="{{ $item->article->title }}">
    </div>
    <div class="community-details__content">
        <h1 class="title">{{ $item->article->title }}</h1>
        <a class="btn is-purple" href="{{ $item->article->url }}">
            @lang('community.buttons.view_article_details')
        </a>
    </div>
</div>