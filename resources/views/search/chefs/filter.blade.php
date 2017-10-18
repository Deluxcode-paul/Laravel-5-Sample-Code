<div class="panel-body">
    <p>@lang('search/chefs.labels.refine_your_search')</p>
    {{ Form::open([
        'url' => route('search.chef'),
        'method' => 'GET',
        'class' => 'form-horizontal js-filter-form',
        'role' => 'form'
    ]) }}

    <div class="form-group">
        {{ Form::label('role_id', trans('search/chefs.labels.filter'), [
            'class' => 'col-md-4 control-label'
        ]) }}

        <div class="col-md-6">
            {{ Form::select('role_id', $filter->get('roles'), $filterValues['role_id'], [
                'placeholder' => trans('search/chefs.placeholders.roles')
            ]) }}
        </div>
    </div>

    <div class="form-group">
        {{ Form::label('country_id', trans('search/chefs.labels.location'), [
            'class' => 'col-md-4 control-label'
        ]) }}


        <div class="col-md-6">
            {{ Form::select('country_id', $filter->get('countries'), $filterValues['country_id'], [
                'placeholder' => trans('search/chefs.placeholders.country')
            ]) }}
        </div>
    </div>

    <div class="js-state-container">
        <div class="form-group">
            <div class="col-md-6">
                {{ Form::select('state_id', $filter->get('states'), $filterValues['state_id'], [
                    'placeholder' => trans('search/chefs.placeholders.state')
                ]) }}
            </div>
        </div>
    </div>

    <div class="form-group">
        <div class="col-md-8 col-md-offset-4">
            <button type="submit" class="btn btn-primary">
                @lang('search/chefs.buttons.apply_filters')
            </button>

            <a class="btn btn-link js-clear-filters" href="#">
                @lang('search/chefs.buttons.clear_all_filters')
            </a>
        </div>
    </div>


    {{ Form::close() }}
</div>
