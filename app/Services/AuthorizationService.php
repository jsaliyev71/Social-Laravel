<?php

namespace App\Services;

use App\Models\Role;
use App\Models\User;

class AuthorizationService {
    
    public function haveAuthority(User $user, string $permissionCode, int $roleId, ?int $communityId = null): bool {

        return $user->userRoles()
            ->where('role_id', $roleId)
            ->where('status', 'active')
            ->when($communityId, function ($q) use($communityId) {
                $q->where('community_id', $communityId);
            })
            ->whereHas('role.permissions', function($q) use($permissionCode) {
                $q->where('code', $permissionCode);
            })
            ->exists();
            
    }
}

