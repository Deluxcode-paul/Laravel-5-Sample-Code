<?php

use App\Facades\BfmVideo;
use Illuminate\Database\Seeder;

/**
 * Class VideoTitleSeeder
 */
class VideoTitleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $videos = DB::table('videos')->whereNull('title')->get();
        foreach ($videos as $video) {
            if (empty($video->video_id) || empty($video->video_type)) {
                $videoData = BfmVideo::getData($video->video);
            } else {
                $videoData = BfmVideo::getDataById($video->video_id, $video->video_type);
            }

            if (!empty($videoData['title'])) {
                DB::table('videos')->where('id', $video->id)->update([
                    'title' => $videoData['title']
                ]);
            }
        }
    }
}
