<div class="panel-body">
    {{ Form::open([
        'url' => route('lifestyle'),
        'method' => 'GET',
        'class' => 'form-horizontal js-sort-form',
        'role' => 'form'
    ]) }}

    <div class="form-group">
        {{ Form::label('sort', trans('pages/lifestyle.labels.sort_by'), [
            'class' => 'col-md-4 control-label'
        ]) }}

        <div class="col-md-6">
            {{ Form::select('sort', $sorting, $sortValue, [
                'class' => 'js-sort-selector'
            ]) }}
        </div>
    </div>
    {{ Form::close() }}
</div>
