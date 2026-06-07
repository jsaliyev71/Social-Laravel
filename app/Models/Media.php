<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Media extends Model
{
    protected $fillable = [
        'uploader_user_id',
        'owner_type',
        'owner_id',
        'file_url',
        'media_type',
        'width',
        'height',
        'file_name',
        'mime_type',
        'file_size',
        'duration_seconds',
    ];

    public function owner() {
        return $this->morphTo();
    }

    public function user() {
        return $this->belongsTo(User::class, 'uploader_user_id');
    }
}
