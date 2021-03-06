<h3 onclick="$(this).next().toggleClass('hidden');">@lang('recipes/list.courses-title')</h3>
<div class="block hidden">
    <div class="short-info">
        @foreach($categories['all'] as $id=>$label)
            <input type="checkbox"
                   data-id="{{ $id }}"
                   data-counter="{{ (isset($i))?$i++:($i = 0) }}"
                   name="{{$categories['key']}}[{{ $id }}]"
                   {{ $categories['selected']->contains($label) ? 'checked="checked"' : '' }}>
            {{ $label }}
            </input><br/>
            @if ($i==1)
                </div>
                <span class="js-more" onclick="$(this).next().toggleClass('hidden');">@lang('recipes/list.view_more')</span>
                <div class="more hidden">
            @endif
        @endforeach
    </div>
</div>

