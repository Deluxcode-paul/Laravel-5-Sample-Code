<div class="cms-page__section">
    <div class="site-width">
        <div class="cms-page__inner">
            <div class="heading-decorative">
                @unless(empty($model->heading))
                    <h3 class="heading-decorative__title"><span>{{ $model->heading }}</span></h3>
                @endunless
                <h2 class="heading-decorative__subtitle">{{ $model->name }}</h2>
            </div>
            <div class="cms-page__content">
                <div class="cms-page__faq cms-faq">
                    <ul class="cms-faq__list">
                        @foreach($model->items as $item)
                        <li class="cms-faq__item j-faq-accordion">
                            <a href="#" class="cms-faq__opener j-faq-accordion-opener">
                                {{ $item->question }}
                            </a>
                            <div class="cms-faq__content">
                                {{ $item->answer }}
                            </div>
                        </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>