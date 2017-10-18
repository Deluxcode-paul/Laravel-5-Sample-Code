@if ( count($preferences['all']) > 0 )

    <div class="switcher is-flexible is-brown">
        <ul>
            @foreach($preferences['all'] as $id=>$label)
                <li>
                    <label class="switcher__item">
                        <input
                            type="radio"
                            data-id="{{ $id }}"
                            value="{{ $id }}"
                            name="{{$preferences['key']}}[]"
                            {{ $activePreference == $id ? ' checked="checked" ' : '' }}
                            class=" js-preference {{ $activePreference == $id ? ' selected ' : '' }} ">
                        <span class="switcher__title">{{ $label }}</span>
                    </label>
                </li>
            @endforeach
        </ul>
    </div>

@endif