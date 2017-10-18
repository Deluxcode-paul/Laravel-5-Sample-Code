<div class="panel-body">
    <p>@lang('search/lifestyle.labels.refine_your_search')</p>
    {{ Form::open([
        'url' => route('search.lifestyle'),
        'method' => 'GET',
        'class' => 'form-horizontal js-filter-form',
        'role' => 'form'
    ]) }}

    <div class="form-group">
        {{ Form::label('category_id', trans('search/lifestyle.labels.filter'), [
            'class' => 'col-md-4 control-label'
        ]) }}

        <div class="col-md-6">
            {{ Form::select('category_id', $filter->get('categories'), $filterValues['category_id'], [
                'placeholder' => trans('search/lifestyle.placeholders.categories')
            ]) }}
        </div>
    </div>

    <div class="form-group">
        {{ Form::label('year', trans('search/lifestyle.labels.archives'), [
            'class' => 'col-md-4 control-label'
        ]) }}

        <div class="col-md-6">
            {{ Form::select('year', $filter->get('years'), $filterValues['year'], [
                'placeholder' => trans('search/lifestyle.placeholders.year')
            ]) }}
        </div>

        <div class="col-md-6">
            {{ Form::select('month', $filter->get('months'), $filterValues['month'], [
                'placeholder' => trans('search/lifestyle.placeholders.month')
            ]) }}
        </div>
    </div>

    <div class="form-group">
        <div class="col-md-8 col-md-offset-4">
            <button type="submit" class="btn btn-primary">
                @lang('search/lifestyle.buttons.apply_filters')
            </button>

            <a class="btn btn-link js-clear-filters" href="#">
                @lang('search/lifestyle.buttons.clear_all_filters')
            </a>
        </div>
    </div>


    {{ Form::close() }}
</div>
