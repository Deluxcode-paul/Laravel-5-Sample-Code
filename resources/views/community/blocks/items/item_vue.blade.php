<template>
    <a href="@{{ item.user.publicProfileUrl }}">
        <img v-bind:src="item.user.activityImage" alt="@{{ item.user.fullName }}">
    </a>
    <p>
        @lang('community.posted_by')
        <a href="@{{ item.user.publicProfileUrl }}">
            @{{ $item.user.fullName }}
        </a>
        , @{{ $item.publishedAt }}
    </p>
    <p>
        <a href="@{{ item.detailsUrl }}">
            @{{ item.title }}
        </a>
    </p>
    <p v-if="item.hasRating">@{{ item.rating }}</p>
    <p>@{{ item.details }}</p>
    <ul>
        <li v-for="tag in item.tags">
            <a href="@{{ tag.communitySearchUrl }}">@{{ tag.title }}</a>
        </li>
    </ul>
    <ul>
        <li v-for="chef in item.chefs">
            <a href="@{{ chef.publicProfileUrl }}">@{{ chef.fullName }}</a>
        </li>
    </ul>
    <p>
        <a v-if="item.userCanVote"
           class="js-vote"
           data-id="@{{ item.id }}"
           data-type="@{{ item.dataType }}"
           href="#">
            @{{ item.votes }}
        </a>
        <a v-else>
            @{{ item.votes }}
        </a>
        | @{{ item.replies }} </p>
    <p>
        <a v-if="item.userCanEdit"
           href="@{{ item.editUrl }}">
            @lang('user/profile.activity.edit')
        </a>
    </p>
</template>
