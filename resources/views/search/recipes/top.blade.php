

<input name="{{$keyword['key']}}" value="{{$keyword['selected']}}"/>

<button type="submit">@lang('search/recipes.search')</button>

<hr>
@lang('search/recipes.label_recipes') ( {{$resultsCount}} )

<hr>
<div>
    <h1>{{$header}}</h1>
    <h3>Top myself</h3>

    <div class="sort">
        @lang('recipes/list.sort') {{ Form::select($parameters['sort']['key'], $parameters['sort']['all'], $parameters['sort']['selected'], []) }}
        {{$pager}}
    </div>

    <div class="short-info">
        @foreach($parameters as $key=>$obj)
            @if ( isset($obj['selected']) && is_array($obj['selected']) )
                @foreach ($obj['selected'] as $id=>$label)

                    <a href="#remove"
                       data-id="{{ $id }}"
                       data-key="?{{ $key }}"
                    >  {{ $label }} X

                    </a>&nbsp;

                @endforeach

            @endif
        @endforeach
    </div>
</div>