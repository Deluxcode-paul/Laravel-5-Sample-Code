<div class="cms-page__section is-wysiwyg">
    <div class="site-width">
        <div class="cms-page__inner">
            <div class="heading-decorative">
                @unless(empty($model->heading))
                    <h3 class="heading-decorative__title"><span>{{ $model->heading }}</span></h3>
                @endunless
                <h2 class="heading-decorative__subtitle">{{ $model->name }}</h2>
            </div>
            <div class="cms-page__content">
                {!! $model->content !!}
            </div>
        </div>
    </div>
</div>