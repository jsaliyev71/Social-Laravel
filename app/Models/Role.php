<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Role extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'creator_user_id',
        'community_id',
        'name',
        'scope_type',
    ];

    public function permissions() {
        return $this->belongsToMany(Permission::class, 'role_permissions');
    }

    public function userRoles() {
        return $this->hasMany(UserRole::class ,'role_id', 'id');
    }
}
