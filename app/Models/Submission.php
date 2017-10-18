<?php

namespace App\Models;

use Backpack\CRUD\CrudTrait;

/**
 * Class Submission
 * @package App\Models
 *
 * Table columns:
 * @property integer $id
 * @property integer $user_id
 * @property string $ip_address
 * @property string $inquiry_type
 * @property string $name
 * @property string $email
 * @property string $message
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 */
class Submission extends AppModel
{
    use CrudTrait;

    /**
     * @var string
     */
    protected $table = 'submissions';

    /**
     * @var array
     */
    protected $fillable = [
        'ip_address',
        'user_id',
        'inquiry_type',
        'name',
        'email',
        'message',
    ];

    /**
     * @var bool
     */
    protected $editable = false;

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    /**
     * @return string
     */
    public function getAdminUrl()
    {
        return url('admin/contact-submissions/' . $this->id . '/edit');
    }
}
