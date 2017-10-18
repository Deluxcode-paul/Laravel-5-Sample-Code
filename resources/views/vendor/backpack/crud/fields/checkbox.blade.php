<!-- checkbox field -->

<div @include('crud::inc.field_wrapper_attributes') >
    <div class="checkbox">
    	<label>
    	  <input type="hidden" name="{{ $field['name'] }}" value="0">
    	  <input type="checkbox" value="1"

          name="{{ $field['name'] }}"

          @if (!empty($field['value']) || old($field['name']) == 1 || !empty($field['default']))
             checked="checked"
          @endif

          @if (isset($field['attributes']))
              @foreach ($field['attributes'] as $attribute => $value)
    			{{ $attribute }}="{{ $value }}"
        	  @endforeach
          @endif
          > {!! $field['label'] !!}
    	</label>

        @if (isset($field['hint']))
            <p class="help-block">{!! $field['hint'] !!}</p>
        @endif
    </div>
</div>
