@extends(config('cms-pages.template.layout'))

@section(config('cms-pages.template.styleSection'))
    <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.6.3/css/font-awesome.min.css">
    <link rel="stylesheet" href="/vendor/flex-cms/css/custom.css?v={{ time() }}">
    @if (! config('cms-pages.style.customStyles'))
        <link rel="stylesheet" href="/vendor/flex-cms/css/css-boxes.css?v={{ time() }}">
    @else
        <link rel="stylesheet" href="{{ config('cms-pages.style.customStyles') }}">
    @endif
    @foreach($cssFiles as $filePath)
        <link rel="stylesheet" href="{{ $filePath }}?v={{ time() }}">
    @endforeach
@endsection

@section(config('cms-pages.template.contentHeaderSection'))
<section class="content-header">
    <h1>Construct Page '{{ $page->title }}'</h1>
    @if (Breadcrumbs::exists('cmsPages'))
        {!! Breadcrumbs::render('cmsPages', $urls) !!}
    @endif
</section>
@stop

@section(config('cms-pages.template.contentSection'))
    <div class="row">
        <div class="col-xs-12">
            <div class="cms-box cms-box-primary" style="min-height: 200px">
                <div class="cms-box-header">
                    <ul class="nav nav-pills pull-left" role="tablist">
                        <li role="presentation" class="dropdown">
                            <a id="drop4" href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                                <i class="fa fa-plus"></i> Add Section <span class="caret"></span>
                            </a>
                            <ul class="dropdown-menu add-template-menu" aria-labelledby="drop1">
                                @foreach ($availableCmsTemplates as $template)
                                    <li><a data-type="{{ $template }}" href="#">{{ (new $template())->getName() }}</a></li>
                                @endforeach
                            </ul>
                        </li>
                        <li>
                            <a data-action="preview" href="{{ $page->enabled ? $page->url : route('flex.cms.pages.preview', $page->id) }}">
                                <i class="fa fa-search"></i> Preview
                            </a>
                        </li>
                        <li>
                            <a data-action="save" href="#"><i class="fa fa-save"></i> Save</a>
                        </li>
                        <li>
                            <a data-action="toggle-visibility" href="#"
                               data-other-url="{{ $page->enabled ? route('flex.cms.pages.preview', $page->id) : $page->url }}"
                               data-enabled="{{ $page->enabled ? 1 : 0 }}">
                                @if ($page->enabled)
                                    <i class="fa fa-eye-slash"></i> Unpublish
                                @else
                                    <i class="fa fa-eye"></i> Publish
                                @endif
                            </a>
                        </li>
                    </ul>
                </div>

                <div class="cms-box-body">
                    <div class="templates-list sortable">
                        @foreach ($page->initializedTemplates as $template)
                            @if (View::exists('vendor.flex-cms.backend.wrapper'))
                                @include('vendor.flex-cms.backend.wrapper', ['template' => $template])
                            @else
                                @include('flex.cms::constructor.backend.wrapper', ['template' => $template])
                            @endif
                        @endforeach
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection

@section(config('cms-pages.template.scriptSection'))
    <script src="//cdn.ckeditor.com/4.5.10/full/ckeditor.js"></script>
    <script src="/vendor/flex-cms/js/vendor/AjexFileManager/ajex.js"></script>
    <script src="//code.jquery.com/ui/1.11.4/jquery-ui.min.js"   integrity="sha256-xNjb53/rY+WmG+4L6tTl9m6PpqknWZvRt0rO1SRnJzw=" crossorigin="anonymous"></script>
    <script src="//ajax.aspnetcdn.com/ajax/jquery.validate/1.15.0/jquery.validate.min.js"></script>
    <script src="//ajax.aspnetcdn.com/ajax/jquery.validate/1.15.0/additional-methods.min.js"></script>
    <script src="/vendor/flex-cms/js/vendor/dropzone.js"></script>
    <script src="/vendor/flex-cms/js/vendor/jquery.blockUI.js"></script>
    <script>
        var pageConstructor = {
            config: {
                pageId: parseInt({{ $page->id }}),
                csrfToken: '{{ csrf_token() }}',
                imageMaxFileSize: parseInt({{ config('settings.image_max_file_size', 5120) }}),
                initialFunctions: [@foreach ($initialFunctions as $funcName) '{{ $funcName }}', @endforeach],
                routes: {
                    visibility: '{{ route('flex.cms.pages.visibility') }}',
                    getForm: '{{ route('flex.cms.constructor.getForm') }}',
                    saveTemplates: '{{ route('flex.cms.constructor.saveTemplates') }}',
                    removeTemplates: '{{ route('flex.cms.constructor.removeTemplates')  }}',
                    runCommand: '{{ route('flex.cms.constructor.runCommand') }}'
                }
            }
        };
    </script>
    <script src="/vendor/flex-cms/js/initial-functions.js?v={{ time() }}"></script>
    <script src="/vendor/flex-cms/js/page-constructor.js?v={{ time() }}"></script>
    @foreach($jsFiles as $filePath)
        <script src="{{ $filePath }}?v={{ time() }}"></script>
    @endforeach
@endsection
