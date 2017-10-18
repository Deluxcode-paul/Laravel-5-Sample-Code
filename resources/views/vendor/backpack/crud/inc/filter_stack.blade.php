@if ($filters->count())
    <div class="row">
        @foreach ($filters as $filter)
            @include($filter['view'])
        @endforeach
    </div>
@endif