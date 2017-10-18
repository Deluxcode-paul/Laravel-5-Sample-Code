@include('community.blocks.header_buttons')

<div class="community-details">
    <div class="community-details__img">
        <img src="{{ $item->recipe->getImage('community_details') }}" alt="{{ $item->recipe->title }}">
    </div>
    <div class="community-details__content">
        <h1 class="title">{{ $item->recipe->title }}</h1>
        <a class="btn is-purple" href="{{ $item->recipe->detailUrl }}">
            @lang('community.buttons.view_recipe_details')
        </a>
    </div>
</div>