<template>
    <p>@lang('search/common.no_results.heading', ['query' => $keyword['selected']])</p>
    <p>@lang('search/common.no_results.suggestions')</p>
    <ul>
        <li><p>@lang('search/common.no_results.suggestion1')</p></li>
        <li><p>@lang('search/common.no_results.suggestion2')</p></li>
        <li><p>@lang('search/common.no_results.suggestion3')</p></li>
    </ul>
    <p><a href="{{ route('contact') }}">@lang('search/common.no_results.link')</a></p>
</template>