<div>
    @if ($tags->count())
        <p>@lang('community.notification_email.tags', ['count' => $tags->count()])</p>
        <ul>
            @foreach ($tags as $tag)
                <li>
                    <a href="{{ $tag->detailsUrl }}">{{ $tag->title }}</a>
                    <p>{!! nl2br(e($tag->details)) !!}</p>
                </li>
            @endforeach
        </ul>
    @endif

    @if ($replies->count())
        <p>@lang('community.notification_email.replies', ['count' => $replies->count()])</p>
        <ul>
            @foreach ($replies as $reply)
                <li>
                    <p>{!! nl2br(e($reply->details)) !!}</p>
                    <a href="{{ $reply->getOwnerUrl() }}">View Post</a>
                </li>
            @endforeach
        </ul>
    @endif

    @if ($updates->count())
        <p>@lang('community.notification_email.updates', ['count' => $updates->count()])</p>
        <ul>
            @foreach ($updates as $update)
                <li>
                    <p>{!! nl2br(e($update->details)) !!}</p>
                    <a href="{{ $update->getOwnerUrl() }}">View Post</a>
                </li>
            @endforeach
        </ul>
    @endif
</div>