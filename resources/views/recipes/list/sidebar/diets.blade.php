<h3 onclick="$(this).next().toggleClass('hidden');" >@lang('recipes/list.diets-title')</h3>

<div class="block hidden">
    @if ( count($preferences['all']) > 0 )
        @foreach($preferences['all'] as $preferenceId=>$preferencelabel)
                <div class="preference-block preference-block-{{$preferenceId}}    @if ($activePreference == $preferenceId) active  @else hidden @endif ">
                    <div class="short-info">
                        @foreach($diets[$preferenceId] as $id=>$label)
                            <input type="checkbox"
                                   data-id="{{ $id }}"
                                   data-counter="{{ (isset($i))?$i++:($i = 0) }}"
                                   name="{{ $diets['key'] }}[{{ $id }}]"
                                   {{ $diets['selected']->contains($label) ? 'checked="checked"' : '' }}>
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

