@extends('backpack::layout')

@section('header')
    <section class="content-header">
        <h1>
            {{ trans('backpack::crud.add') }} <span class="text-lowercase">
                @unless (empty($heading))"{{ $heading }}" @endunless{{ $crud->entity_name }}
            </span>
        </h1>
        @if (Breadcrumbs::exists('crud'))
            {!! Breadcrumbs::render('crud', empty($breadcrumbs) ? [] : $breadcrumbs) !!}
        @endif
    </section>
@endsection

@section('content')
    <div>
        @if ($crud->hasAccess('list'))
            @include('vendor.backpack.crud.buttons.bfm_back')
        @endif

        {!! Form::open([
            'url' => $crud->route,
            'method' => 'post',
            'name' => 'crud-create',
            'autocomplete' => 'off'
        ]) !!}
        @if ($hasPasswordField)
        <input type="text" name="fakeusername" value="" style="display:none" />
        <input type="password" name="fakeuserpassword" value="" style="display:none" />
        @endif
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title">{{ trans('backpack::crud.add_a_new') }} {{ $crud->entity_name }}</h3>
            </div>
            <div class="box-body row">
                <!-- load the view from the application if it exists, otherwise load the one in the package -->
                @if(view()->exists('vendor.backpack.crud.form_content'))
                    @include('vendor.backpack.crud.form_content', ['fields' => $crud->getFields('create')])
                @else
                    @include('crud::form_content', ['fields' => $crud->getFields('create')])
                @endif
            </div><!-- /.box-body -->
            <div class="box-footer">
                <div class="form-group">
                    <span>{{ trans('backpack::crud.after_saving') }}:</span>
                    <div class="radio">
                        <label>
                            <input type="radio" name="redirect_after_save" value="{{ $crud->route }}" checked="">
                            {{ trans('backpack::crud.go_to_the_table_view') }}
                        </label>
                    </div>
                    <div class="radio">
                        <label>
                            <input type="radio" name="redirect_after_save" value="{{ $crud->route.'/create' }}">
                            {{ trans('backpack::crud.let_me_add_another_item') }}
                        </label>
                    </div>
                    <div class="radio">
                        <label>
                            <input type="radio" name="redirect_after_save" value="current_item_edit">
                            {{ trans('backpack::crud.edit_the_new_item') }}
                        </label>
                    </div>
                </div>
                @if ($crud->buttons->where('stack', 'form')->count())
                    @include('crud::inc.button_stack', ['stack' => 'form'])
                @else
                    @include('vendor.backpack.crud.buttons.form.bfm_save')
                    @include('vendor.backpack.crud.buttons.form.bfm_cancel')
                @endif
            </div><!-- /.box-footer-->
        </div><!-- /.box -->
        {!! Form::close() !!}
    </div>
@endsection
