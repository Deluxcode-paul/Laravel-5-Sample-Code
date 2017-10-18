@if ($holidays->count())
    <section class="section-holidays">
        <div class="spacer">
            <h3 class="section-holidays__title">@lang('common.holiday')</h3>
            <ul class="list-category">
                @foreach($holidays as $holiday)
                    <li>
                        <a href="{{ $holiday->getSubCategoryUrl() }}" title="{{ $holiday->title }}">
                            <img src="{{ $holiday->getImage('holiday_recipes_category') }}" alt="{{ $holiday->title }}" />
                            <span>{{ $holiday->title }}</span>
                        </a>
                    </li>
                @endforeach
            </ul>
        </div>
    </section>
@endif