<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'username',
        'email',
        'password',
        'display_name',
        'bio',
        'gender',
        'profile_pic',
        'banner_img',
        'birth_date',
        'is_active',
        'is_banned',
        'last_login_at',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function userRoles() {
        return $this->hasMany(UserRole::class, 'user_id', 'id');
    }

    public function userSettings() {
        return $this->hasOne(UserSettings::class, 'user_id', 'id');
    }

    public function communities() {
        return $this->hasMany(Community::class, 'owner_user_id', 'id');
    }

    public function follows() {
        return $this->hasMany(CommunityMember::class, 'user_id', 'id');
    }

    public function reacted() {
        return $this->hasMany(PostReaction::class, 'user_id', 'id');
    }

    public function comments() {
        return $this->hasMany(Comment::class, 'user_id', 'id');
    }
    
    public function commentReactions() {
        return $this->hasMany(CommentReaction::class, 'user_id', 'id');
    }
}



