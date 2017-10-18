@if($recipe->cooking->count())
    <section class="recipe-details__steps section-steps">
        <div class="section-steps__heading">
            <h2 class="section-steps__title">@lang('recipe/view.start_cooking')</h2>
            @if($recipe->hasCookingImages())
                <div class="section-steps__switcher">
                    <span class="switcher-title">@lang('recipe/view.images'):</span>
                    <div class="switcher">
                        <ul>
                            <li>
                                <label class="switcher__item">
                                    {{ Form::radio('switch-images', 'on', false, [
                                        'class' => 'js-ingredient-ckb',
                                        'autocomplete' => 'off'
                                    ]) }}
                                    <span class="switcher__title">{{ trans('recipe/view.on') }}</span>
                                </label>
                            </li>
                            <li>
                                <label class="switcher__item">
                                    {{ Form::radio('switch-images', 'off', true, [
                                        'class' => 'js-ingredient-ckb',
                                        'autocomplete' => 'off'
                                    ]) }}
                                    <span class="switcher__title">{{ trans('recipe/view.off') }}</span>
                                </label>
                            </li>
                        </ul>
                    </div>
                </div>
            @endif
        </div>
        <div class="section-steps__box box js-steps">
            @foreach($recipe->cooking as $cooking)
                @include('recipe.blocks.cooking_steps.cooking')
            @endforeach
        </div>
    </section>
@endif
