<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $rolePermissions = [
            'super_admin' => [
                // POSTS
                'post.create',
                'post.edit_own',
                'post.edit_any',
                'post.delete_own',
                'post.delete_any',
                'post.view_sensitive',
                'post.pin',
                'post.unpin',
                'post.lock_comments',
                'post.unlock_comments',
                'post.change_visibility',
                'post.approve',
                'post.reject',
                'post.manage_sections',

                // COMMENTS
                'comment.create',
                'comment.edit_own',
                'comment.edit_any',
                'comment.delete_own',
                'comment.delete_any',
                'comment.hide',
                'comment.unhide',
                'comment.lock',
                'comment.unlock',

                // COMMUNITIES
                'community.view_private',
                'community.update',
                'community.delete',
                'community.manage_settings',
                'community.manage_visibility',
                'community.manage_sections',
                'community.manage_profile',

                // MEMBERS
                'member.view',
                'member.invite',
                'member.approve_join',
                'member.reject_join',
                'member.remove',
                'member.ban',
                'member.unban',
                'member.mute',
                'member.unmute',
                'member.manage_nicknames',
                'member.manage_profile_overrides',

                // ROLES
                'role.view',
                'role.create',
                'role.update',
                'role.delete',
                'role.assign',
                'role.unassign',
                'role.manage_permissions',

                // MESSAGES
                'message.create',
                'message.edit_own',
                'message.delete_own',
                'message.delete_any',
                'message.pin',
                'message.unpin',
                'message.manage_conversations',

                // MODERATION
                'moderation.view_reports',
                'moderation.resolve_reports',
                'moderation.audit_logs',
                'moderation.manage_sensitive',
                'moderation.override_locks',

                // SYSTEM
                'system.admin_access',
                'system.manage_categories',
                'system.manage_users',
                'system.ban_users',
                'system.view_dev_logs',
                'system.manage_permissions',
                'system.manage_roles',
            ],

            'admin' => [
                'post.create',
                'post.edit_own',
                'post.edit_any',
                'post.delete_own',
                'post.delete_any',
                'post.view_sensitive',
                'post.pin',
                'post.unpin',
                'post.lock_comments',
                'post.unlock_comments',
                'post.change_visibility',
                'post.approve',
                'post.reject',
                'post.manage_sections',

                'comment.create',
                'comment.edit_own',
                'comment.edit_any',
                'comment.delete_own',
                'comment.delete_any',
                'comment.hide',
                'comment.unhide',
                'comment.lock',
                'comment.unlock',

                'community.view_private',
                'community.update',
                'community.manage_settings',
                'community.manage_visibility',
                'community.manage_sections',
                'community.manage_profile',

                'member.view',
                'member.invite',
                'member.approve_join',
                'member.reject_join',
                'member.remove',
                'member.ban',
                'member.unban',
                'member.mute',
                'member.unmute',
                'member.manage_nicknames',
                'member.manage_profile_overrides',

                'role.view',
                'role.create',
                'role.update',
                'role.assign',
                'role.unassign',
                'role.manage_permissions',

                'message.create',
                'message.edit_own',
                'message.delete_own',
                'message.delete_any',
                'message.pin',
                'message.unpin',
                'message.manage_conversations',

                'moderation.view_reports',
                'moderation.resolve_reports',
                'moderation.audit_logs',
                'moderation.manage_sensitive',
                'moderation.override_locks',
            ],

            'moderator' => [
                'post.create',
                'post.edit_own',
                'post.edit_any',
                'post.delete_own',
                'post.delete_any',
                'post.view_sensitive',
                'post.pin',
                'post.unpin',
                'post.lock_comments',
                'post.unlock_comments',
                'post.approve',
                'post.reject',

                'comment.create',
                'comment.edit_own',
                'comment.edit_any',
                'comment.delete_own',
                'comment.delete_any',
                'comment.hide',
                'comment.unhide',
                'comment.lock',
                'comment.unlock',

                'community.view_private',

                'member.view',
                'member.approve_join',
                'member.reject_join',
                'member.remove',
                'member.mute',
                'member.unmute',

                'role.view',

                'message.create',
                'message.edit_own',
                'message.delete_own',
                'message.delete_any',
                'message.pin',
                'message.unpin',

                'moderation.view_reports',
                'moderation.resolve_reports',
                'moderation.audit_logs',
                'moderation.manage_sensitive',
                'moderation.override_locks',
            ],

            'member' => [
                'post.create',
                'post.edit_own',
                'post.delete_own',

                'comment.create',
                'comment.edit_own',
                'comment.delete_own',

                'member.view',

                'message.create',
                'message.edit_own',
                'message.delete_own',
            ],

            'user' => [
                // keep this one minimal and site-level in spirit
                'message.create',
            ],
        ];

        foreach ($rolePermissions as $roleName => $permissionData) {
            $role = Role::where('name', $roleName)
                ->whereNull('community_id')
                ->first();

            if (! $role) {
                continue;
            }

            $permissionIds = Permission::whereIn('code', $permissionData)->pluck('id')->toArray();

            $role->permissions()->sync($permissionIds);
        }
    }
}
