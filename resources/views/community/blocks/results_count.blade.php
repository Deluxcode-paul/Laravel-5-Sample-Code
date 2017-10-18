@if ($filterValues[KosherHelper::getSearchKeywordParameter()])
    <p>
        {{ $totalResults }} @lang('community.results_count', [
        'keyword' => $filterValues[KosherHelper::getSearchKeywordParameter()]
        ])
    </p>
@endif
