@extends('backpack::layout')

@section('header')
    <section class="content-header">
        <h1>
            {{ trans('backpack::crud.edit') }} <span class="text-lowercase">
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

        {!! Form::open(array('url' => $crud->route.'/'.$entry->getKey(), 'method' => 'put', 'name' => 'crud-edit', 'novalidate')) !!}
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title">{{ trans('backpack::crud.edit') }}</h3>
                @if ($crud->buttons->where('stack', 'form_header')->count())
                    <div style="float:right">
                        @include('crud::inc.button_stack', ['stack' => 'form_header'])
                    </div>
                @endif
            </div>
            <div class="box-body row">
                <!-- load the view from the application if it exists, otherwise load the one in the package -->
                @if(view()->exists('vendor.backpack.crud.form_content'))
                    @include('vendor.backpack.crud.form_content')
                @else
                    @include('crud::form_content', ['fields' => $crud->getFields('update', $entry->getKey())])
                @endif
            </div><!-- /.box-body -->
            @if ($entry->isEditable())
            <div class="box-footer">
                @if ($crud->buttons->where('stack', 'form')->count())
                    @include('crud::inc.button_stack', ['stack' => 'form'])
                @else
                    @include('vendor.backpack.crud.buttons.form.bfm_save')
                    @include('vendor.backpack.crud.buttons.form.bfm_cancel')
                @endif
            </div><!-- /.box-footer-->
            @endif
        </div><!-- /.box -->
        {!! Form::close() !!}
    </div>
@endsection
