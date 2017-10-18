<li>
    <div>{!! $step->description !!}</div>
    @unless(empty($step->image))
        <img src="#" data-src="{{ $step->getImage() }}" alt="{{ $cooking->title }}" />
    @endunless
</li>