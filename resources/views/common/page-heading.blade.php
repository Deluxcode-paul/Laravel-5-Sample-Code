{{-- 

    Variables:

    $bg - path to the bg image
    $breadcrumb - name of the breadcrumb
    $title0 - first line of heading
    $title1 - second line of heading

 --}}

<section class="page-heading" style="background-image: url('{{ URL('/') . $bg }}');">
    <div class="site-width">
        {!! Breadcrumbs::render('recipes.category') !!}
        <div class="page-heading__spacer">
            <div class="heading-decorative">
                <h1 class="heading-decorative__title"><span>{{ $title0 }}</span></h1>
                <h2 class="heading-decorative__subtitle">{{ $title1 }}</h2>
            </div>
        </div>
    </div>
</section>