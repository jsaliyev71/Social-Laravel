<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CommunityMember extends Model
{
    protected $fillable = [
        'community_id',
        'user_id',
        'color',
        'community_pic',
        'community_nickname',
        'status',
        'is_muted',
        'notify_new_posts',
        'notify_announcements',
        'joined_at'
    ];

    public function user() {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function community() {
        return $this->belongsTo(User::class, 'community_id');
    }
}
