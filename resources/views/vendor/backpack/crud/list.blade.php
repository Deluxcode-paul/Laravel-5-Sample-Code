@extends('backpack::layout')

@adminlteAssets('datatables')
@backpackAssets('crud/list.js')

@section('header')
    <section class="content-header">
        <h1>
            <span class="text-capitalize">
                @unless (empty($heading))"{{ $heading }}" @endunless{{ $crud->entity_name_plural }}
            </span>
        </h1>
        @if (Breadcrumbs::exists('crud'))
            {!! Breadcrumbs::render('crud', empty($breadcrumbs) ? [] : $breadcrumbs) !!}
        @endif
    </section>
@endsection

@section('content')
    <div class="box">
        <div class="box-header {{ $crud->hasAccess('create')?'with-border':'' }}">
            @include('crud::inc.button_stack', ['stack' => 'top'])
            @if ($crud->buttons->where('stack', 'relation_top')->count())
                <div style="float:right;">
                    @include('crud::inc.button_stack', ['stack' => 'relation_top'])
                </div>
            @endif
        </div>
        @if (isset($filters) && $filters->count())
            @backpackAssets('crud/filter.js')
            <div class="box-header with-border backpack-filters">
                {{ Form::open(['method' => 'post', 'route' => 'backend.ajax.filter', 'class' => 'form']) }}
                {{ Form::hidden('controller', $controller) }}
                @include('vendor.backpack.crud.inc.filter_stack')
                <button class="btn btn-success ladda-button" type="submit">
                    @lang('crud.buttons.filter')
                </button>
                <button class="btn btn-default ladda-button" id="js-clear-filters">
                    @lang('crud.buttons.clear')
                </button>
                {{ Form::close() }}
            </div>
        @endif
        <div class="box-body">
            <table id="crudTable" class="table table-bordered table-hover display" @unless(empty($order)) data-order="{{ $order }}" @endunless>
                <thead>
                <tr>
                    @if ($crud->details_row)
                        <th></th> <!-- expand/minimize button column -->
                    @endif

                    {{-- Table columns --}}
                    @foreach ($crud->columns as $column)
                        <th @include('crud::inc.column_attributes') >{{ $column['label'] }}</th>
                    @endforeach

                    @if ($crud->buttons->where('stack', 'relation_line')->count())
                        <th data-orderable="false">@lang('crud.labels.relations')</th>
                    @endif

                    @if ($crud->buttons->where('stack', 'line')->count())
                        <th data-orderable="false" width="{{ ($crud->buttons->where('stack', 'line')->count() - 2) * 19 }}px">{{ trans('backpack::crud.actions') }}</th>
                    @endif
                </tr>
                </thead>
                <tbody>
                @if (!$crud->ajaxTable())
                    @foreach ($entries as $k => $entry)
                        <tr data-entry-id="{{ $entry->getKey() }}">
                            @if ($crud->details_row)
                                @include('crud::columns.details_row_button')
                            @endif

                            @foreach ($crud->columns as $column)
                                @if (!isset($column['type']))
                                    @include('crud::columns.text')
                                @else
                                    @if(view()->exists('vendor.backpack.crud.columns.'.$column['type']))
                                        @include('vendor.backpack.crud.columns.'.$column['type'])
                                    @else
                                        @if(view()->exists('crud::columns.'.$column['type']))
                                            @include('crud::columns.'.$column['type'])
                                        @else
                                            @include('crud::columns.text')
                                        @endif
                                    @endif
                                @endif
                            @endforeach

                            @if ($crud->buttons->where('stack', 'relation_line')->count())
                                <td>
                                    @include('crud::inc.button_stack', ['stack' => 'relation_line'])
                                </td>
                            @endif

                            @if ($crud->buttons->where('stack', 'line')->count())
                                <td>
                                    @include('crud::inc.button_stack', ['stack' => 'line'])
                                </td>
                            @endif
                        </tr>
                    @endforeach
                @endif
                </tbody>
                <tfoot>
                <tr>
                    @if ($crud->details_row)
                        <th></th> <!-- expand/minimize button column -->
                    @endif

                    {{-- Table columns --}}
                    @foreach ($crud->columns as $column)
                        <th>{{ $column['label'] }}</th>
                    @endforeach

                    @if ($crud->buttons->where('stack', 'relation_line')->count())
                        <th>@lang('crud.labels.relations')</th>
                    @endif

                    @if ( $crud->buttons->where('stack', 'line') )
                        <th>{{ trans('backpack::crud.actions') }}</th>
                    @endif
                </tr>
                </tfoot>
            </table>
        </div>
        @include('crud::inc.button_stack', ['stack' => 'bottom'])
    </div>
@endsection
