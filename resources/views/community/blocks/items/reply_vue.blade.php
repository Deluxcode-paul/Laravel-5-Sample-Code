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
    <p>@{{ item.details }}</p>
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
    </p>
    <p>
        <a v-if="item.userCanEdit"
           href="@{{ item.editUrl }}">
            @lang('user/profile.activity.edit')
        </a>
        <a v-if="item.userCanReport"
           class="js-report-abuse"
           data-id="@{{ item.id }}"
           data-type="@{{ item.dataType }}"
           href="#">
            @lang('user/profile.activity.report_abuse')
        </a>
    </p>
</template>