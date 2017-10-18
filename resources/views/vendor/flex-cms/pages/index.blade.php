@extends(config('cms-pages.template.layout'))

@section(config('cms-pages.template.contentHeaderSection'))
<section class="content-header">
    <h1>Cms Pages</h1>
    @if (Breadcrumbs::exists('cmsPages'))
        {!! Breadcrumbs::render('cmsPages', [['title' => 'Pages Tree', 'url' => route('flex.cms.pages_tree')]]) !!}
    @endif
</section>
@stop

@section(config('cms-pages.template.contentSection'))
    <div class="box">
        <div class="box-header with-border">
            <a href="{{ url('admin/cms/create') }}" class="btn btn-primary ladda-button">
                <i class="fa fa-plus"></i>
                Add CMS Page
            </a>
            <a href="{{ url('admin/cms') }}" class="btn btn-default ladda-button">
                <i class="fa fa-newspaper-o"></i>
                CMS Pages
            </a>
        </div>
        <div class="box-body">
            <div id="tree"></div>
        </div>
    </div>
@endsection

@section(config('cms-pages.template.scriptSection'))
    <link rel="stylesheet" href="/vendor/flex-cms/css/vendor/jqtree.css">
    <script src="/vendor/flex-cms/js/vendor/tree.jquery.js"></script>
    <link rel="stylesheet" href="/vendor/flex-cms/css/custom.css?v={{ time() }}">
    <script>
        var pagesTree = {
            config: {
                tree: {!! $tree !!},
                csrfToken: '{{ csrf_token() }}',
                routes: {
                    move: '{{ route('flex.cms.pages.move') }}',
                    visibility: '{{ route('flex.cms.pages.visibility') }}'
                }
            }
        };
    </script>
    <script src="/vendor/flex-cms/js/pages-tree.js?v={{ time() }}"></script>
@endsection
