<li>
    <div>{!! $step->description !!}</div>
    @unless(empty($step->image))
        <img src="{{ $step->getImage() }}" alt="{{ $cooking->title }}" />
    @endunless
</li>