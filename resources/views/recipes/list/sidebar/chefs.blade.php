<h3 onclick="$(this).next().toggleClass('hidden');" >@lang('recipes/list.chefs-title')</h3>

<div class="block hidden">
    <input class="js-findChefs" placeholder="@lang('recipes/list.search-chefs')" />
    {{--

     For autocompletelink
      POST to: /search/chefs
      parameter: w

      result will looks like [
      1=>'title1,
      2=>'title2,
      3=>'title3,
      ]
      --}}
    <br/>
    @if ( count($chefs['selected']) > 0 )
        @foreach($chefs['selected'] as $id=>$label)
            <span data-id="{{ $id }}" >{{ $label }}
                <input type="hidden" name="{{$chefs['key']}}[{{ $id }}]" value="{{$id}}"/>
                <a
                        data-id="{{ $id }}"
                        href="#">
                @lang('recipes/list.remove')
            </a>
        </span>
        @endforeach
    @endif

</div>

