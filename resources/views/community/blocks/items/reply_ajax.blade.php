<a href="{{ $item->user->publicProfileUrl }}">
    <img src="{{ $item->user->activityImage}}" alt="{{ $item->user->fullName }}">
</a>
<p>
        @lang('community.posted_by')
        <a href="{{ $item->user->publicProfileUrl }}">
                {{ $item->user->fullName }}
        </a>
        , {{ $item->publishedAt }}
</p>
<p>{{ $item->details }}</p>
<p>
    @can('vote', $item)
        <a class="js-vote"
           data-id="{{ $item->id }}"
           data-type="{{ $item->dataType }}"
           href="#">
            {{ $item->votes }}
        </a>
    @endcan
    @cannot('vote', $item)
        {{ $item->votes }}
    @endcannot
</p>
<p>
    @can('edit', $item)
        <a href="{{ $item->editUrl }}">
            @lang('user/profile.activity.edit')
        </a>
    @endcan
    @can('report', $item)
        <a class="js-report-abuse"
           data-id="{{ $item->id }}"
           data-type="{{ $item->dataType }}"
           href="#">
            @lang('user/profile.activity.report_abuse')
        </a>
    @endcan
</p>