<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserRole extends Model
{
    protected $table = 'user_roles';

    protected $fillable = [
        'user_id',
        'role_id',
        'community_id',
        'assigner_user_id',
        'status',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function assignerUser()
    {
        return $this->belongsTo(User::class, 'assigner_user_id');
    }

    public function role()
    {
        return $this->belongsTo(Role::class, 'role_id');
    }

    public function community()
    {
        return $this->belongsTo(Community::class, 'community_id');
    }
}