<div class="cms-page__section">
    <div class="site-width">
        <div class="heading-decorative">
            @unless(empty($model->heading))
                <h3 class="heading-decorative__title"><span>{{ $model->heading }}</span></h3>
            @endunless
            <h2 class="heading-decorative__subtitle">{{ $model->name }}</h2>
        </div>
        <div class="cms-page__content">
            <div class="cms-page__tabs cms-tabs box-tabs js-responsive-tabs">
                <ul class="cms-tabs__list tabset uppercase">
                    @foreach($model->items as $key=>$item)
                        <li><a href="#tab{{ ++$key }}">{{ $item->label }}</a></li>
                    @endforeach
                </ul>
                @foreach($model->items as $key=>$item)
                    <div class="cms-tabs__item" id="tab{{ ++$key }}">
                        <div class="cms-page__inner">
                            <div class="cms-tabs__content">
                                {!! $item->content !!}
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>