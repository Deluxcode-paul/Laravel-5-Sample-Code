<?php

namespace App\Http\Controllers\Frontend\Pages\Watch;

use App\Http\Controllers\Controller;
use App\Models\Video;
use Assets;

class GetVideo extends Controller
{
    /**
     * @param Video $video
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function __invoke(Video $video)
    {
        Assets::group('frontend')->addJs('share/email.js');
        Assets::group('frontend')->addJs('pages/video.js');

        return view('pages.watch.video', compact('video'));
    }
}
