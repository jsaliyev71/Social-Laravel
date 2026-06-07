<?php

namespace App\Models;

use App\PostStatus;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Post extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'community_id',
        'section_id',
        'user_id',
        'title',
        'content',
        'description',
        'post_status',
        'visibility',
        'post_type',
        'is_pinned',
        'is_sensitive',
        'comments_enabled',
        'sharing_enabled',
        'published_at',
        'edited_at'
    ];

    protected $casts = [
        'published_at' => 'datetime',
        'status' => PostStatus::class
    ];

    public function user(): BelongsTo {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function community(): BelongsTo {
        return $this->belongsTo(Community::class, 'community_id');
    }

    public function section(): BelongsTo {
        return $this->belongsTo(CommunitySection::class, 'section_id');
    }

    public function media(): MorphMany {
        return $this->morphMany(Media::class, 'owner');
    }

    public function reactions(): HasMany {
        return $this->hasMany(PostReaction::class, 'post_id', 'id');
    }

    public function comments(): HasMany {
        return $this->hasMany(Comment::class, 'post_id', 'id');
    }
}
