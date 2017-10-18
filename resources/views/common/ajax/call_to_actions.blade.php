@if ($actions->count())
    <div class="site-width">
        <div class="section-spacer">
            <ul>
                @foreach($actions as $action)
                    <li>
                        <div class="item-spacer">
                            <div class="item-cta" style="background-image: url('{{ $action->getImage('call_to_action') }}');">
                                <div class="item-cta__holder">
                                    <div class="item-cta__wrapper item-cta__wrapper-dummy"></div>
                                    <a href="{{ $action->link }}" class="item-cta__wrapper">
                                        <h3 class="item-cta__title">{{ $action->title }}</h3>
                                        <div class="item-cta__hide">
                                            <div class="row item-cta__descr">
                                                <p>{{ $action->description }}</p>
                                            </div>
                                            <div class="row item-cta__action">
                                                <span class="btn is-brown">{{ $action->button_text }}</span>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
@endif