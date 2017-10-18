<?php

namespace App\Http\Controllers\Frontend\Pages\Watch\Video\Share;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use App\Models\Video;
use App\Http\Requests\Frontend\Pages\Watch\Video\VideoEmailRequest;
use App\Mail\SendVideo;

class SendMail extends Controller
{
    /**
     * @param VideoEmailRequest $request
     * @param Video $video
     * @return \Illuminate\Http\JsonResponse
     */
    public function __invoke(VideoEmailRequest $request, Video $video)
    {
        Mail::to($request->get('email'))->send(new SendVideo($video));

        return response()->json(['message' => trans('share.mail_to_already_sent'), 'type'=>'success']);
    }
}
