<div class="cms-page__section is-columns">
    <div class="site-width">
        <div class="cms-page__inner">
            <div class="heading-decorative">
                @unless(empty($model->heading))
                    <h3 class="heading-decorative__title"><span>{{ $model->heading }}</span></h3>
                @endunless
                <h2 class="heading-decorative__subtitle">{{ $model->name }}</h2>
            </div>
            <div class="cms-page__content">
                <div class="cms-page__columns">
                    <div class="cms-page__column">
                        {!! $model->column1 !!}
                    </div>
                    <div class="cms-page__column">
                        {!! $model->column2 !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>