<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Comment extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'post_id',
        'user_id',
        'parent_comment_id',
        'content',
        'comment_status'
    ];

    public function post() {
        return $this->belongsTo(Post::class, 'post_id');
    }

    public function user() {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function media() {
        return $this->morphMany(Media::class, 'owner');
    }

    public function parent() {
        return $this->belongsTo(Comment::class, 'parent_comment_id');
    }

    public function replies() {
        return $this->hasMany(Comment::class, 'parent_comment_id', 'id');
    }

    public function reactions() {
        return $this->hasMany(CommentReaction::class, 'comment_id', 'id');
    }
}
