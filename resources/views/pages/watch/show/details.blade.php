<div class="img" style="background-image: url('{{ $show->getBannerImage() }}');">
    <div class="site-width">
        {!! Breadcrumbs::render('show', $show) !!}
    </div>
    <div class="content">
        <div class="site-width">
            <div class="wrap">
                <img src="{{ $show->getLogoImage() }}" alt="{{ $show->title }}" />
                <h1 class="title">{{ $show->title }}</h1>
                <div class="desc">{{ str_limit($show->description, 360, '') }}</div>
                @if ($showChefs->count() > 0)
                <span class="meta">
                    @lang('pages/show.labels.featuring')
                    @foreach ($showChefs as $i => $chef)
                        <a class="link" href="{{ $chef->publicProfileUrl }}">{{ $chef->fullName }}</a>@if ($i < ($showChefs->count() - 1)), @endif
                    @endforeach
                </span>
                @endif
            </div>
        </div>
    </div>
</div>