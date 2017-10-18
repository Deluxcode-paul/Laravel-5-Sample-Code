<h3 onclick="$(this).next().toggleClass('hidden');">@lang('recipes/list.cookTimes-title')</h3>

<div class="block hidden">
    <div class="short-info">
        @foreach($cookTimes['all'] as $id=>$label)
            <input type="checkbox"
                   data-id="{{ $id }}"
                   data-counter="{{ (isset($i))?$i++:($i = 0) }}"
                   name="{{$cookTimes['key']}}[{{ $id }}]"
                    {{ in_array($id, array_keys($cookTimes['selected'])) ? 'checked="checked"' : '' }}>
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
