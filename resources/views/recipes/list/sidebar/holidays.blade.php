<h3 onclick="$(this).next().toggleClass('hidden');" >@lang('recipes/list.holidays-title')</h3>

<div class="block hidden">
    @if ( count($preferences['all']) > 0 )
        @foreach($preferences['all'] as $preferenceId=>$preferencelabel)
                <div class="preference-block preference-block-{{$preferenceId}}    @if ($activePreference == $preferenceId) active  @else hidden @endif ">
                    <div class="short-info">
                        @foreach($holidays[$preferenceId] as $id=>$label)
                            <input type="checkbox"
                                   data-id="{{ $id }}"
                                   data-counter="{{ (isset($i))?$i++:($i = 0) }}"
                                   name="{{ $holidays['key'] }}[{{ $id }}]"
                                   {{ $holidays['selected']->contains($label) ? 'checked="checked"' : '' }}>
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
        @endforeach
    @endif
</div>

