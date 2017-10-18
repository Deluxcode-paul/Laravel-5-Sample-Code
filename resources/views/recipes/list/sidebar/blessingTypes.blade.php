<h3 onclick="$(this).next().toggleClass('hidden');">@lang('recipes/list.blessingTypes-title')</h3>

<div class="block hidden">
    <div class="short-info">
        @foreach($blessingTypes['all'] as $id=>$label)
            <input type="checkbox"
                   data-id="{{ $id }}"
                   data-counter="{{ (isset($i))?$i++:($i = 0) }}"
                   name="{{ $blessingTypes['key'] }}[{{ $id }}]"
                   {{ $blessingTypes['selected']->contains($label) ? ' checked="checked" ' : '' }}>
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
