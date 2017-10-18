<?php

namespace App\Models;

use Backpack\CRUD\CrudTrait;
use App\Facades\BfmImage;

/**
 * Class CallToAction
 * @package App\Models
 *
 * @property integer $id
 * @property string $title
 * @property string $description
 * @property string $button_text
 * @property string $link
 * @property string $image
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 */
class CallToAction extends AppModel
{
    use CrudTrait;

    /**
     * @var string
     */
    protected $table = 'call_to_actions';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title',
        'description',
        'button_text',
        'link',
        'image'
    ];

    /**
     * The attributes that should be processed as images.
     *
     * @var array
     */
    protected $images = [
        'image'
    ];

    /**
     * @param string $size
     * @return mixed
     */
    public function getImage($size = 'call_to_action')
    {
        return BfmImage::init($this->image)->get($size);
    }

    /**
     * @param string $size
     * @param int $blur
     * @return string
     */
    public function getBlurredImage($size = 'call_to_action', $blur = 60)
    {
        return BfmImage::init($this->image)->blur($blur)->get($size);
    }
}
