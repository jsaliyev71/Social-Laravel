<?php

namespace App\Models;

use App\Models\Role;
use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    protected $fillable = [
        'code',
        'name',
        'description',
        'category',
        'scope_type'
    ];

    public function roles() {
        return $this->belongsToMany(Role::class, 'role_permissions');
    }
}
