<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Attachment extends Model
{
    protected $fillable = [
        'attachable_id',
        'attachable_type',
        'filename',
        'path',
        'mime_type',
        'size'
    ];

    public function attachable()
    {
        return $this->morphTo();
    }
}
