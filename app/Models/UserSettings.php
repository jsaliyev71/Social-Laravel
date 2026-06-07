<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserSettings extends Model
{
    protected $fillable = [
        'user_id',
        'language',
        'theme',
        'is_notifications_muted',
        'allow_message_requests',
        'follow_mode',
        'profile_visibility',
        'post_visibility',
        'comment_visibility'
    ];

    public function user() {
        return $this->belongsTo(User::class, 'user_id');
    }
}
