<?php

namespace App\Services;

use App\Models\User;

class AuthService {

    public function isSuperAdmin(User $user): bool {
        return $user->userRoles()
            ->where('status', 'active')
            ->whereNull('community_id')
            ->whereHas('role', function($q) {
                $q->where([
                    'name' => 'super_admin',
                    'scope_type' => 'system'
                ]);
            })->exists();
    }

    public function isCommunityOwner(User $user, $community): bool {
        
        if (!$community || !$user) {
            return false;
        }

        if (isset($community->owner_user_id) && $community->owner_user_id === $user->id) {
            return true;
        }

        return false;
    }
}