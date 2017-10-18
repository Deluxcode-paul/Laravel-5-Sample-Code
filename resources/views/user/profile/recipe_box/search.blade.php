<div>
    <div class="panel-body">
        {{ Form::open([
            'url' => route('user.profile.recipe-box.view'),
            'method' => 'GET',
            'class' => 'form-horizontal',
            'role' => 'form'
        ]) }}
        <div class="form-group">
            <div class="col-md-6">
                {{ Form::text('query', $query, [
                    'placeholder' => trans('user/profile.placeholders.search'),
                    'maxlength' => 255,
                    'class' => 'form-control',
                 ]) }}
            </div>
        </div>
        <div class="form-group">
            <div class="col-md-8 col-md-offset-4">
                <button type="submit" class="btn btn-primary">
                    @lang('user/profile.buttons.search')
                </button>
            </div>
        </div>
        {{ Form::close() }}
    </div>
</div>