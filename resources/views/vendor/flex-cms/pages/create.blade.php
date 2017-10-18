@extends(config('cms-pages.template.layout'))

@section(config('cms-pages.template.contentHeaderSection'))
<section class="content-header">
    <h1>Create Page</h1>
    @if (Breadcrumbs::exists('cmsPages'))
        {!! Breadcrumbs::render('cmsPages', $urls) !!}
    @endif
</section>
@stop

@section(config('cms-pages.template.contentSection'))
    <div class="row">
        <div class="col-md-12">
            <a href="{{ route('flex.cms.pages_tree') }}">
                <i class="fa fa-angle-double-left"></i>
                {{ trans('backpack::crud.back_to_all') }}
                <span class="text-lowercase">CMS Pages</span>
            </a>
            <br><br>

            {{ Form::open(['url' => route('flex.cms.pages.store')]) }}
            {{ Form::hidden('enabled', 0) }}
            {{ Form::hidden('layout', reset($pageLayouts)) }}

            <div class="box">
                <div class="box-body row">
                    <div class="form-group col-md-12 @if($errors->get('title')) has-error @endif">
                        <label for="title">Title <small>(Required)</small></label>
                        <input type="text" class="form-control" name="title" id="title" value="{{ old('title') }}">
                        @if ($errors->get('title'))
                            <span class="help-block">{{ $errors->first('title') }}</span>
                        @endif
                    </div>

                    <div class="form-group col-md-12 @if($errors->get('headline')) has-error @endif" >
                        <label for="title">Headline</label>
                        <input type="text" class="form-control" name="headline" id="headline" value="{{ old('headline') }}">
                        @if ($errors->get('headline'))
                            <span class="help-block">{{ $errors->first('headline') }}</span>
                        @endif
                    </div>

                    <div class="form-group col-md-12 @if($errors->get('keywords')) has-error @endif">
                        <label for="keywords">Keywords</label>
                        <input type="text" class="form-control" name="keywords" id="keywords" value="{{ old('keywords') }}">
                        @if ($errors->get('keywords'))
                            <span class="help-block">{{ $errors->first('keywords') }}</span>
                        @endif
                    </div>

                    <div class="form-group col-md-12 @if($errors->get('description')) has-error @endif">
                        <label for="description">Description</label>
                        <input type="text" class="form-control" name="description" id="description" value="{{ old('description') }}">
                        @if ($errors->get('description'))
                            <span class="help-block">{{ $errors->first('description') }}</span>
                        @endif
                    </div>

                    <div class="form-group col-md-12 @if($errors->get('alias')) has-error @endif">
                        <label for="alias">Alias <small>(Required)</small></label>
                        <input type="text" class="form-control" name="alias" id="alias" value="{{ old('alias') }}">
                        @if ($errors->get('alias'))
                            <span class="help-block">{{ $errors->first('alias') }}</span>
                        @else
                            <span class="help-block">Only letters, numbers, dashes. No spaces.</span>
                        @endif
                    </div>
                </div>
                <div class="box-footer">
                    <button class="btn btn-success ladda-button" type="submit" data-style="zoom-in">
                        <span class="ladda-label">
                            <i class="fa fa-save"></i> Save
                        </span>
                    </button>
                    <a href="{{ route('flex.cms.pages_tree') }}" class="btn btn-default ladda-button" data-style="zoom-in">
                        <span class="ladda-label">{{ trans('backpack::crud.cancel') }}</span>
                    </a>
                </div>
            </div>
            {{ Form::close() }}
        </div>
    </div>
@endsection