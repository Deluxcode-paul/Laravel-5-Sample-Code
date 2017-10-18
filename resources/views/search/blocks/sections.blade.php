<div class="site-width">
    <ul class="search-tabs">
        <li>
            <a href="{{ route('search.recipes').'?'.$keyword['key'].'='.$keyword['selected'] }}"
               class="{{ $count['recipes'] == 0 ? 'is-disabled' : '' }}">
                @lang('search/common.labels.recipes') <span class="count">({{ $count['recipes'] }})</span>
            </a>
        </li>
        <li>
            <a href="{{ route('search.lifestyle').'?'.$keyword['key'].'='.$keyword['selected'] }}"
               class="{{ $count['lifestyle'] == 0 ? 'is-disabled' : '' }}">
                @lang('search/common.labels.lifestyle') <span class="count">({{ $count['lifestyle'] }})</span>
            </a>
        </li>
        <li>
            <a href="{{ route('search.chef').'?'.$keyword['key'].'='.$keyword['selected'] }}"
               class="{{ $count['chefs'] == 0 ? 'is-disabled' : '' }}">
                @lang('search/common.labels.chefs') <span class="count">({{ $count['chefs'] }})</span>
            </a>
        </li>
        <li>
            <a href="{{ route('search.watch').'?'.$keyword['key'].'='.$keyword['selected'] }}"
               class="{{ $count['watch'] == 0 ? 'is-disabled' : '' }}">
                @lang('search/common.labels.watch') <span class="count">({{ $count['watch'] }})</span>
            </a>
        </li>
    </ul>
</div>
