<?php

use App\Facades\BfmVideo;
use Illuminate\Database\Seeder;

/**
 * Class VideoIdSeeder
 */
class VideoIdSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $videos = DB::table('videos')->whereNull('video_id')->get();
        foreach ($videos as $video) {
            $videoType = BfmVideo::getType($video->video);
            $videoId = BfmVideo::getVideoId($videoType, $video->video);
            if (!empty($videoId)) {
                DB::table('videos')->where('id', $video->id)->update([
                    'video_type' => $videoType,
                    'video_id' => $videoId
                ]);
            }
        }
    }
}
