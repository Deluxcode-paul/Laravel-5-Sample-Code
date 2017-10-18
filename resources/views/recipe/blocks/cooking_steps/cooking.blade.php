<section class="step">
    <h3 class="step__title">{{ $cooking->title }}</h3>
    <div class="step__content">
        <div class="step__descr">{!! $cooking->description !!}</div>
        @if($cooking->steps->count())
            <ol>
                @if (isset($print) && $print == 1)
                    @foreach($cooking->steps()->orderBy('lft', 'asc')->get() as $step)
                        @include('recipe.blocks.cooking_steps.step_print')
                    @endforeach
                @else
                    @foreach($cooking->steps()->orderBy('lft', 'asc')->get() as $step)
                        @include('recipe.blocks.cooking_steps.step')
                    @endforeach
                @endif
            </ol>
        @endif
    </div>
    @unless(empty($cooking->note) && empty($cooking->tip) && empty($cooking->variation))
        <div class="step__additional">
            @unless(empty($cooking->note))
                <div class="row">
                    <strong class="def">@lang('recipe/view.note'):</strong>
                    {!! $cooking->note !!}
                </div>
            @endunless
            @unless(empty($cooking->tip))
                <div class="row">
                    <strong class="def">@lang('recipe/view.tip'):</strong>
                    {!! $cooking->tip !!}
                </div>
            @endunless
            @unless(empty($cooking->variation))
                <div class="row">
                    <strong class="def">@lang('recipe/view.variation'):</strong>
                    {!! $cooking->variation !!}
                </div>
            @endunless
        </div>
    @endunless
</section>