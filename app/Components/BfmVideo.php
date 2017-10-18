<?php

namespace App\Components;

use Sseffa\VideoApi\Facades\VideoApi;

/**
 * Class BfmVideo
 * @package App\Components
 */
final class BfmVideo
{
    const TYPE_YOUTUBE = 'youtube';
    const TYPE_VIMEO = 'vimeo';
    const TYPE_UNKNOWN = '';

    const VIMEO_OEMBED_API = 'https://vimeo.com/api/oembed.json?url=';

    /**
     * @var string
     */
    private $youtubeApiKey = '';

    /**
     * BfmVideo constructor.
     */
    public function __construct()
    {
        $this->youtubeApiKey = config('video-api.youtube_api_key');
    }

    /**
     * @param string $url
     * @return array
     */
    public function getData($url)
    {
        $data = [];
        $type = $this->getType($url);
        switch ($type) {
            case self::TYPE_YOUTUBE:
                $data = VideoApi::setType($type)
                    ->setKey(config('video-api.youtube_api_key'))
                    ->getVideoDetail($this->getVideoId($type, $url));
                break;
            case self::TYPE_VIMEO:
                $data = VideoApi::setType($type)
                    ->getVideoDetail($this->getVideoId($type, $url));
                break;
            default:
                break;
        }

        return $data;
    }

    /**
     * @param string $id
     * @param string $type
     * @return array
     */
    public function getDataById($id, $type)
    {
        $data = [];
        switch ($type) {
            case self::TYPE_YOUTUBE:
                $data = VideoApi::setType($type)->setKey(config('video-api.youtube_api_key'))->getVideoDetail($id);
                break;
            case self::TYPE_VIMEO:
                $data = VideoApi::setType($type)->getVideoDetail($id);
                break;
            default:
                break;
        }

        return $data;
    }

    /**
     * @param string $url
     * @return string
     */
    public function getType($url)
    {
        if ($this->isYoutube($url)) {
            return self::TYPE_YOUTUBE;
        } elseif ($this->isVimeo($url)) {
            return self::TYPE_VIMEO;
        } else {
            return self::TYPE_UNKNOWN;
        }
    }

    /**
     * @return array
     */
    public function getValidTypes()
    {
        return [
            self::TYPE_VIMEO,
            self::TYPE_YOUTUBE
        ];
    }

    /**
     * @param string $type
     * @param string $url
     * @return string
     */
    public function getVideoId($type, $url)
    {
        switch ($type) {
            case self::TYPE_YOUTUBE:
                return $this->getYouTubeVideoId($url);
                break;
            case self::TYPE_VIMEO:
                $curl = curl_init(self::VIMEO_OEMBED_API . urlencode($url));
                curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
                $vimeo = curl_exec($curl);
                curl_close($curl);
                $vimeo = json_decode($vimeo);
                if (isset($vimeo->video_id)) {
                    return $vimeo->video_id;
                }
                break;
            default:
                break;
        }

        return '';
    }

    /**
     * @param string $url
     * @return bool
     */
    public function isYoutube($url)
    {
        return boolval(preg_match('/youtu\.be/i', $url) || preg_match('/youtube\.com/i', $url));
    }

    /**
     * @param string $url
     * @return bool
     */
    public function isVimeo($url)
    {
        return boolval(preg_match('/vimeo\.com/i', $url));
    }

    /**
     * Get embed URL
     *
     * @param string $type
     * @param string $id
     * @return string
     */
    public function getEmbedUrl($type, $id)
    {
        switch ($type) {
            case self::TYPE_YOUTUBE:
                $url = '//www.youtube.com/embed/' . $id;
                break;
            case self::TYPE_VIMEO:
                $url = '//player.vimeo.com/video/' . $id;
                break;
            default:
                $url = '';
                break;
        }

        return $url;
    }

    /**
     * @param string $url
     * @return string
     */
    private function getYouTubeVideoId($url)
    {
        $video_id = '';
        $url = parse_url($url);
        if (strcasecmp($url['host'], 'youtu.be') === 0) {
            $video_id = substr($url['path'], 1);
        } elseif (strcasecmp($url['host'], 'www.youtube.com') === 0) {
            if (isset($url['query'])) {
                parse_str($url['query'], $url['query']);
                if (isset($url['query']['v'])) {
                    $video_id = $url['query']['v'];
                }
            }

            if (empty($video_id)) {
                $url['path'] = explode('/', substr($url['path'], 1));
                if (in_array($url['path'][0], array('e', 'embed', 'v'))) {
                    $video_id = $url['path'][1];
                }
            }
        }

        return $video_id;
    }
}
