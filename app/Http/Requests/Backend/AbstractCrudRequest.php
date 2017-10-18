<?php

namespace App\Http\Requests\Backend;

use App\Facades\BfmImage;
use App\Facades\BfmVideo;
use App\Facades\KosherHelper;
use App\Models\Tag;
use Backpack\CRUD\app\Http\Requests\CrudRequest;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;

/**
 * Class AbstractCrudRequest
 * @package App\Http\Requests\Backend
 */
abstract class AbstractCrudRequest extends CrudRequest
{
    /**
     * @var array
     */
    private $videoData;

    /**
     * @return $this
     */
    public function processVideos()
    {
        foreach ($this->getCrudModel()->getVideosProperty() as $attribute) {
            $this->saveVideo($attribute);
        }

        return $this;
    }

    /**
     * @return $this
     */
    public function processImages()
    {
        foreach ($this->getCrudModel()->getImagesProperty() as $attribute) {
            $this->saveImage($attribute);
        }

        return $this;
    }

    /**
     * @return $this
     */
    public function processDates()
    {
        foreach ($this->getCrudModel()->getDatesProperty() as $attribute) {
            $this->formatDate($attribute);
        }

        return $this;
    }

    /**
     * @return $this
     */
    public function processTags()
    {
        $this->setPrimaryKey();
        $tags = [];
        $tagsInput = $this->input('tags');

        if (is_string($tagsInput)) {
            $tagsArray = explode(Tag::SEPARATOR, $tagsInput);
            $tagsArray = array_filter($tagsArray);
            foreach ($tagsArray as $tagTitle) {
                $tag = Tag::where('title', trim($tagTitle))->first();

                if (empty($tag)) {
                    $tag = new Tag();
                    $tag->title = trim($tagTitle);
                    $tag->save();
                }

                $tags[] = $tag->id;
            }
        }

        if (!is_array($tags)) {
            $tags = [];
        }

        $this->merge(['tags' => $tags]);

        return $this;
    }

    /**
     * @return $this
     */
    public function processPassword()
    {
        $password = $this->input('password');
        if (empty($password)) {
            $this->offsetUnset('password');
        } else {
            $this->merge(['password' => Hash::make($password)]);
        }

        return $this;
    }

    /**
     * @return $this
     */
    public function processRole()
    {
        $roles = $this->input('roles');
        if (!is_array($roles)) {
            $this->merge(['roles' => [$roles]]);
        }

        return $this;
    }

    /**
     * @return $this
     */
    public function processWysiwyg()
    {
        foreach ($this->getCrudModel()->getWysiwygProperty() as $attribute) {
            $this->trimWysiwygContent($attribute);
        }

        return $this;
    }

    /**
     * @return string
     */
    abstract protected function setCrudModel();

    /**
     * @return \App\Models\AppModel
     * @throws \Exception
     */
    protected function getCrudModel()
    {
        $model = $this->setCrudModel();
        if (!class_exists($model)) {
            throw new \Exception('This model does not exist.', 404);
        }

        return new $model();
    }

    /**
     * @param $attribute
     */
    private function trimWysiwygContent($attribute)
    {
        $source = $this->input($attribute);
        $entry = $this->getEntry();
        if (!empty($source) && (empty($entry) || $source != $entry->$attribute)) {
            $filtered = KosherHelper::filterWysiwygContent($source);
            if (empty($filtered)) {
                $this->merge([
                    $attribute => ''
                ]);
            }
        }
    }

    /**
     * @param string $attribute
     * @return void
     */
    private function saveImage($attribute)
    {
        $source = $this->input($attribute);
        $entry = $this->getEntry();
        if (!empty($source) && (empty($entry) || $source != $entry->$attribute)) {
            $sourceFilePath = BfmImage::getPublicPath($source);
            $targetFilePath = BfmImage::generateFullPath(basename($sourceFilePath));

            $this->merge([
                $attribute => BfmImage::save($sourceFilePath, $targetFilePath)
            ]);
        }
    }

    /**
     * @param string $attribute
     * @return void
     */
    private function formatDate($attribute)
    {
        $date = $this->get($attribute);
        if ($date) {
            $value = Carbon::createFromFormat(
                config('backpack.base.default_date_format'),
                $this->get($attribute)
            )->toDateString();

            $this->merge([$attribute => $value]);
        }
    }

    /**
     * @return void
     */
    protected function setPrimaryKey()
    {
        $pkFieldName = $this->getCrudModel()->getKeyName();
        $pkFieldValue = $this->get($pkFieldName);
        if (empty($pkFieldValue)) {
            $httpRequest = \Request::instance();
            $pkFieldValue = $httpRequest->get($pkFieldName);
        }
        $this->merge([$pkFieldName => $pkFieldValue]);
    }

    /**
     * @return mixed
     */
    private function getEntry()
    {
        $id = intval($this->get($this->getCrudModel()->getKeyName()));
        if (empty($id)) {
            return null;
        }

        return $this->getCrudModel()->find($id);
    }

    /**
     * @param string $attribute
     * @return void
     */
    private function saveVideo($attribute)
    {
        $source = $this->input($attribute);
        $entry = $this->getEntry();

        if (!empty($source) && (!$entry || $source != $entry->{$attribute})) {
            $this->saveVideoId($source);
            $this->saveVideoType($source);
            $this->saveVideoImage($source);
            $this->saveVideoTitle($source);
        }
    }

    /**
     * @param string $source
     */
    private function saveVideoId($source)
    {
        $videoData = $this->getVideoData($source);
        if (!empty($videoData['id'])) {
            $this->merge([
                'video_id' => $videoData['id']
            ]);
        }
    }

    /**
     * @param string $source
     */
    private function saveVideoType($source)
    {
        $videoType = BfmVideo::getType($source);
        if (!empty($videoType)) {
            $this->merge([
                'video_type' => $videoType
            ]);
        }
    }

    /**
     * @param string $source
     */
    private function saveVideoImage($source)
    {
        $image = $this->input('image');
        if (isset($image) && empty($image)) {
            $videoData = $this->getVideoData($source);

            if (!empty($videoData['thumbnail_large'])) {
                $imagePath = BfmImage::saveExternal($videoData['thumbnail_large']);
                $this->merge([
                    'image' => $imagePath
                ]);
            }
        }
    }

    /**
     * @param string $source
     */
    private function saveVideoTitle($source)
    {
        $title = $this->input('title');
        if (isset($title) && empty($title)) {
            $videoData = $this->getVideoData($source);

            if (!empty($videoData['title'])) {
                $this->merge([
                    'title' => $videoData['title']
                ]);
            }
        }
    }

    /**
     * @param string $source
     * @return mixed
     */
    private function getVideoData($source)
    {
        if (empty($this->videoData[$source])) {
            $this->videoData[$source] = BfmVideo::getData($source);
        }

        return $this->videoData[$source];
    }
}
