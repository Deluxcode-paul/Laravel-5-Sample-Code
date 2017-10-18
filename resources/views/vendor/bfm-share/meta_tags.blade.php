<meta property="og:url" content="{{ isset($url) ? $url : URL::full() }}"/>
@if(isset($title))
    <meta property="og:title" content="{{ $title }}"/>
@endif
@if(isset($description))
    <meta property="og:description" content="{{ $description }}"/>
@endif
@if(isset($imageUrl))
    <meta property="og:image" content="{{ $imageUrl }}"/>
    <meta property="og:image:width" content="{{ isset($imageWidth) ? $imageWidth : 1200 }}" />
    <meta property="og:image:height" content="{{ isset($imageHeight) ? $imageHeight : 1200 }}" />
@endif
@if(isset($imageSecureUrl))
    <meta property="og:image:secure_url" content="{{ $imageSecureUrl }}"/>
@endif
