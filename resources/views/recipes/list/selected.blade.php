<div class="listing__selected">
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