<div class="ingredients">
    
</div>

@lang('recipes/list.ingredients')
<br/>

@lang('recipes/list.with')
<br/>
<input class="js-findWith" placeholder="@lang('recipes/list.search-ingredients')" />
{{--

 For autocompletelink
    POST to: /search/ingredient
    parameter: w

    result will looks like [
    1=>'title1,
    2=>'title2,
    3=>'title3,
    ]
    --}}
<br/>
@if ( count($ingredientsWith['selected']) > 0 )
        @foreach($ingredientsWith['selected'] as $id=>$label)
                <input type="hidden" name="{{$ingredientsWith['key']}}[{{ $id }}]" value="{{$id}}"/>
                <span data-id="{{ $id }}" >{{ $label }}
                        <a
                                        data-id="{{ $id }}"
                                        data-type="without"
                                        href="#">
                                @lang('recipes/list.remove')
                        </a>

                </span>
        @endforeach
@endif

<br/>
<br/>


@lang('recipes/list.without')
<br/>
<input class="js-findWithout" placeholder="@lang('recipes/list.search-ingredients')" />
<br/>
@if ( count($ingredientsWithout['selected']) > 0 )
        @foreach($ingredientsWithout['selected'] as $id=>$label)
                <input type="hidden" name="{{$ingredientsWithout['key']}}[{{ $id }}]" value="{{$id}}"/>
                <span data-id="{{ $id }}" >{{ $label }}
                        <a
                                        data-id="{{ $id }}"
                                        data-type="without"
                                        href="#">
                                @lang('recipes/list.remove')
                        </a>
                </span>
        @endforeach
@endif
