<div class="listing__panel">
    <div class="sort">
        @lang('recipes/list.sort') {{ Form::select($parameters['sort']['key'], $parameters['sort']['all'], $parameters['sort']['selected'], []) }}
        {{$pager}}
    </div>
    @include('recipes.list.pageSize', ['links' => $pageSize['all']])
</div>