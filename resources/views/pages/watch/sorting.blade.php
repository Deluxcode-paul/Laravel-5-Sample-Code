<div class="panel-body">
    {{ Form::open([
        'url' => route('watch'),
        'method' => 'GET',
        'class' => 'form-horizontal js-sort-form',
        'role' => 'form'
    ]) }}

    <div class="form-group">
        {{ Form::label('sort', trans('pages/watch.labels.sort_by'), [
            'class' => 'col-md-4 control-label'
        ]) }}

        <div class="col-md-6">
            {{ Form::select('sort', $filter->get('sort'), $filterValues['sort'], [
                'class' => 'js-sort-selector'
            ]) }}
        </div>
    </div>
    {{ Form::close() }}
</div>
