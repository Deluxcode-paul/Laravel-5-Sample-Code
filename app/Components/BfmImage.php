<?php

namespace App\Components;

use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\File;

/**
 * Class BfmImage
 * @package App\Components
 */
final class BfmImage
{
    const PLACEHOLDER_DIR = 'images';
    const UPLOAD_DIR = 'uploads';
    const UPLOAD_DEPTH = 2;
    const RESIZE_DIR = 'resized';
    const BLUR_DIR = 'blurred';
    const IMAGE_SIZES_CONFIG = 'images.sizes';
    const IMAGE_QUALITY = 70;

    const RESIZE_HEIGHT = 1; // 01
    const RESIZE_WIDTH = 2; // 10
    const RESIZE_AND_CROP = 3; // 11

    /**
     * @var string
     */
    private $filename = '';

    /**
     * @var int
     */
    private $blur = 0;

    /**
     * @var boolean
     */
    private $secure = false;

    /**
     * @var boolean
     */
    private $placeholder = false;

    /**
     * @param string $filename
     * @return $this
     */
    public function init($filename = '')
    {
        $this->filename = $filename;
        $this->blur = 0;
        $this->secure = false;
        $this->placeholder = false;

        return $this;
    }

    /**
     * @param integer $value
     * @return $this
     */
    public function blur($value = 1)
    {
        $value = intval($value);

        if (100 < $value) {
            $value = 100;
        }

        if (0 > $value) {
            $value = 0;
        }

        $this->blur = $value;

        return $this;
    }

    /**
     * @param integer $value
     * @return $this
     */
    public function secure($value = 1)
    {
        $this->secure = boolval($value);

        return $this;
    }

    /**
     * @param integer $value
     * @return $this
     */
    public function placeholder($value = 1)
    {
        $this->placeholder = boolval($value);

        return $this;
    }

    /**
     * Get thumbnail image path
     *
     * @param string $size
     * @return string
     */
    public function get($size = 'original')
    {
        if (empty($this->filename)) {
            return '';
        }

        $resizedPath = $this->generateResizedPath($size);
        $fullResizedPath = $this->generateFullResizedPath($size, $resizedPath);

        if (!File::exists($fullResizedPath)) {
            $this->resize($size, $resizedPath);
        }

        if ($this->secure) {
            return secure_url($resizedPath);
        } else {
            return url($resizedPath);
        }
    }

    /**
     * @return array
     */
    public function getAllowedMimeTypes()
    {
        return [
            'image/jpeg',
            'image/png',
            'image/gif',
        ];
    }

    /**
     * Get full path to file in public dir
     *
     * @param string $path
     * @return string
     */
    public function getPublicPath($path)
    {
        return implode('/', array_filter([
            public_path(),
            $path
        ]));
    }

    /**
     * Relative path to saved image
     *
     * @param string $filename
     * @return string
     */
    public function generatePath($filename)
    {
        $pathElements = [];
        $newFileName = $this->cleanFileName(File::name($filename));

        for ($i = 0; $i < self::UPLOAD_DEPTH; $i++) {
            if (isset($newFileName[$i])) {
                $pathElements[] = strtolower($newFileName[$i]);
            }
        }

        $pathElements[] = implode('.', array_filter([
            $newFileName,
            File::extension($filename)
        ]));

        return implode('/', array_filter($pathElements));
    }

    /**
     * Full path to saved image
     *
     * @param string $filename
     * @return string
     */
    public function generateFullPath($filename)
    {
        return implode('/', array_filter([
            public_path(self::UPLOAD_DIR),
            $this->generatePath($filename)
        ]));
    }

    /**
     * Save image
     *
     * @param string $sourcePath
     * @param string $targetPath
     * @return string
     */
    public function save($sourcePath, $targetPath)
    {
        if (File::exists($sourcePath)) {
            $targetPath = $this->checkTargetPath($targetPath);
            Image::make($sourcePath)->save($targetPath);

            return File::basename($targetPath);
        }

        return '';
    }

    /**
     * Copy image
     *
     * @param string $source
     * @return string
     */
    public function saveExternal($source)
    {
        $image = Image::make($source);
        if ($image) {
            $targetPath = BfmImage::generateFullPath(basename($source));
            $targetPath = $this->checkTargetPath($targetPath);
            $image->save($targetPath);

            return File::basename($targetPath);
        }

        return '';
    }

    /**
     * @param string $fileName
     * @return boolean
     */
    public function isLost($fileName)
    {
        return !(File::exists($this->generateFullPath($fileName)));
    }

    /**
     * @param string $sourcePath
     * @param string $targetPath
     * @return mixed
     */
    public function orientateAndSave($sourcePath, $targetPath)
    {
        Image::make($sourcePath)->orientate()->save($targetPath);

        return File::basename($targetPath);
    }

    /**
     * Resize image
     *
     * @param string $size
     * @param string $resized
     * @return string
     */
    private function resize($size = 'original', $resized = '')
    {
        if ($this->placeholder) {
            $originalPath = implode('/', array_filter([
                public_path(self::PLACEHOLDER_DIR),
                $this->filename
            ]));
        } else {
            $originalPath = $this->generateFullPath($this->filename);
        }

        if (File::exists($originalPath)) {
            $img = Image::make($originalPath);
            $img = $this->resolveSize($img, $size);

            if (0 < $this->blur) {
                $img->blur($this->blur);
            }

            if (empty($resized)) {
                $resized = $this->generateResizedPath($size);
            }

            $fullResizedPath = $this->generateFullResizedPath($size, $resized);
            $this->createDirIfNotExists(File::dirname($fullResizedPath));
            $img->save($fullResizedPath, self::IMAGE_QUALITY);
        }

        return url($resized);
    }

    /**
     * @param string $size
     * @param string $resized
     * @return string
     */
    private function generateFullResizedPath($size, $resized = '')
    {
        if (empty($resized)) {
            $resized = $this->generateResizedPath($size);
        }

        return implode('/', array_filter([
            public_path(),
            $resized
        ]));
    }

    /**
     * @param string $size
     * @return string
     */
    private function generateResizedPath($size)
    {
        return implode('/', array_filter([
            $this->getBaseDir(),
            $size,
            $this->generatePath($this->filename)
        ]));
    }

    /**
     * @return string
     */
    private function getBaseDir()
    {
        if (0 < $this->blur) {
            return self::BLUR_DIR;
        } else {
            return self::RESIZE_DIR;
        }
    }

    /**
     * @param string $targetPath
     * @return string
     */
    private function checkTargetPath($targetPath)
    {
        if (File::exists($targetPath)) {
            if (preg_match('/(.*?)(\d+)$/', File::name($targetPath), $match)) {
                $fileName = $match[1];
                $increment = intval($match[2]);
            } else {
                $fileName = File::name($targetPath);
                $increment = 0;
            }

            do {
                $incrementedFileName = implode('.', array_filter([
                    $fileName . ++$increment,
                    File::extension($targetPath)
                ]));
                $targetPath = $this->generateFullPath($incrementedFileName);
            } while (File::exists($targetPath));
        }

        $this->createDirIfNotExists(File::dirname($targetPath));

        return $targetPath;
    }

    /**
     * Trim and remove whitespaces from filename
     *
     * @param string $name
     * @return string
     */
    private function cleanFileName($name)
    {
        $name = str_replace(' ', '_', trim($name));
        $name = str_replace("'", '', trim($name));
        $name = str_replace('"', '', trim($name));
        $name = str_replace('’', '', trim($name));
        if (empty($name)) {
            $name = md5(time());
        }

        return $name;
    }

    /**
     * @param string $dir
     */
    private function createDirIfNotExists($dir)
    {
        if (!File::isDirectory($dir)) {
            $oldMask = umask(0);
            File::makeDirectory($dir, 0755, true);
            umask($oldMask);
        }
    }

    /**
     * Resolve image size config
     *
     * @param mixed $img
     * @param string $size
     * @return bool
     */
    private function resolveSize($img, $size)
    {
        $size = config(implode('.', [self::IMAGE_SIZES_CONFIG, $size]));

        if ($size) {
            $width = empty($size['width']) ? null : intval($size['width']);
            $height = empty($size['height']) ? null : intval($size['height']);
            $mode = bindec(intval(!empty($width)) . intval(!empty($height)));

            switch ($mode) {
                case self::RESIZE_AND_CROP:
                    $img->fit($width, $height, function ($constraint) {
                        $constraint->upsize();
                    });
                    break;
                case self::RESIZE_WIDTH:
                    $img->resize($width, null, function ($constraint) {
                        $constraint->aspectRatio();
                        $constraint->upsize();
                    });
                    break;
                case self::RESIZE_HEIGHT:
                    $img->resize(null, $height, function ($constraint) {
                        $constraint->aspectRatio();
                        $constraint->upsize();
                    });
                    break;
                default:
                    break;
            }
        }

        return $img;
    }
}
