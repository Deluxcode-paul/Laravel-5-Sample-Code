<div class="panel-body">
    <p>@lang('search/watch.labels.refine_your_search')</p>
    {{ Form::open([
        'url' => route('search.watch'),
        'method' => 'GET',
        'class' => 'form-horizontal js-filter-form',
        'role' => 'form'
    ]) }}

    <div class="form-group">
        {{ Form::label('owner_type', trans('search/watch.labels.filter'), [
            'class' => 'col-md-4 control-label'
        ]) }}

        <div class="col-md-6">
            {{ Form::select('owner_type', $filter->get('owners'), $filterValues['owner_type'], [
                'placeholder' => trans('search/watch.placeholders.all')
            ]) }}
        </div>
    </div>

    <div class="form-group">
        <div class="col-md-8 col-md-offset-4">
            <button type="submit" class="btn btn-primary">
                @lang('search/watch.buttons.apply_filters')
            </button>

            <a class="btn btn-link js-clear-filters" href="#">
                @lang('search/watch.buttons.clear_all_filters')
            </a>
        </div>
    </div>


    {{ Form::close() }}
</div>
