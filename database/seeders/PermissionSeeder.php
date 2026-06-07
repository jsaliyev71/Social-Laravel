<?php

namespace Database\Seeders;

use App\Models\Permission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions = [

            // POSTS
            [
                'code' => 'post.create',
                'name' => 'Create Post',
                'description' => 'Can create posts in the community.',
                'category' => 'posts',
                'scope_type' => 'community',
            ],
            [
                'code' => 'post.edit_own',
                'name' => 'Edit Own Post',
                'description' => 'Can edit own posts',
                'category' => 'posts',
                'scope_type' => 'community',
            ],
            [
                'code' => 'post.edit_any',
                'name' => 'Edit Any Post',
                'description' => 'Can edit any post in the community',
                'category' => 'posts',
                'scope_type' => 'community',
            ],
            [
                'code' => 'post.delete_own',
                'name' => 'Delete Own Post',
                'description' => 'Can delete own posts',
                'category' => 'posts',
                'scope_type' => 'community',
            ],
            [
                'code' => 'post.delete_any',
                'name' => 'Delete Any Post',
                'description' => 'Can delete any post in the community',
                'category' => 'posts',
                'scope_type' => 'community',
            ],
            [
                'code' => 'post.view_sensitive',
                'name' => 'View Sensitive Posts',
                'description' => 'Can view sensitive posts',
                'category' => 'posts',
                'scope_type' => 'community',
            ],
            [
                'code' => 'post.pin',
                'name' => 'Pin Post',
                'description' => 'Can pin posts',
                'category' => 'posts',
                'scope_type' => 'community',
            ],
            [
                'code' => 'post.unpin',
                'name' => 'Unpin Post',
                'description' => 'Can unpin posts',
                'category' => 'posts',
                'scope_type' => 'community',
            ],
            [
                'code' => 'post.lock_comments',
                'name' => 'Lock Post Comments',
                'description' => 'Can disable comments on posts',
                'category' => 'posts',
                'scope_type' => 'community',
            ],
            [
                'code' => 'post.unlock_comments',
                'name' => 'Unlock Post Comments',
                'description' => 'Can enable comments on posts',
                'category' => 'posts',
                'scope_type' => 'community',
            ],
            [
                'code' => 'post.change_visibility',
                'name' => 'Change Post Visibility',
                'description' => 'Can change visibility of posts',
                'category' => 'posts',
                'scope_type' => 'community',
            ],
            [
                'code' => 'post.publish',
                'name' => 'Publish Post',
                'description' => 'Can publish posts',
                'category' => 'posts',
                'scope_type' => 'community',
            ],
            [
                'code' => 'post.approve',
                'name' => 'Approve Post',
                'description' => 'Can approve pending posts',
                'category' => 'posts',
                'scope_type' => 'community',
            ],
            [
                'code' => 'post.reject',
                'name' => 'Reject Post',
                'description' => 'Can reject pending posts',
                'category' => 'posts',
                'scope_type' => 'community',
            ],
            [
                'code' => 'post.manage_sections',
                'name' => 'Manage Post Sections',
                'description' => 'Can assign or move posts between sections',
                'category' => 'posts',
                'scope_type' => 'community',
            ],

            // COMMENTS
            [
                'code' => 'comment.create',
                'name' => 'Create Comment',
                'description' => 'Can create comments',
                'category' => 'comments',
                'scope_type' => 'community',
            ],
            [
                'code' => 'comment.edit_own',
                'name' => 'Edit Own Comment',
                'description' => 'Can edit own comments',
                'category' => 'comments',
                'scope_type' => 'community',
            ],
            [
                'code' => 'comment.edit_any',
                'name' => 'Edit Any Comment',
                'description' => 'Can edit any comment',
                'category' => 'comments',
                'scope_type' => 'community',
            ],
            [
                'code' => 'comment.delete_own',
                'name' => 'Delete Own Comment',
                'description' => 'Can delete own comments',
                'category' => 'comments',
                'scope_type' => 'community',
            ],
            [
                'code' => 'comment.delete_any',
                'name' => 'Delete Any Comment',
                'description' => 'Can delete any comment',
                'category' => 'comments',
                'scope_type' => 'community',
            ],
            [
                'code' => 'comment.hide',
                'name' => 'Hide Comment',
                'description' => 'Can hide comments from public view',
                'category' => 'comments',
                'scope_type' => 'community',
            ],
            [
                'code' => 'comment.unhide',
                'name' => 'Unhide Comment',
                'description' => 'Can restore hidden comments',
                'category' => 'comments',
                'scope_type' => 'community',
            ],
            [
                'code' => 'comment.lock',
                'name' => 'Lock Comment Thread',
                'description' => 'Can lock comment threads',
                'category' => 'comments',
                'scope_type' => 'community',
            ],
            [
                'code' => 'comment.unlock',
                'name' => 'Unlock Comment Thread',
                'description' => 'Can unlock comment threads',
                'category' => 'comments',
                'scope_type' => 'community',
            ],

            // COMMUNITIES
            [
                'code' => 'community.view_private',
                'name' => 'View Private Community',
                'description' => 'Can view private community content',
                'category' => 'communities',
                'scope_type' => 'community',
            ],
            [
                'code' => 'community.update',
                'name' => 'Update Community',
                'description' => 'Can update community details',
                'category' => 'communities',
                'scope_type' => 'community',
            ],
            [
                'code' => 'community.delete',
                'name' => 'Delete Community',
                'description' => 'Can delete the community',
                'category' => 'communities',
                'scope_type' => 'community',
            ],
            [
                'code' => 'community.manage_settings',
                'name' => 'Manage Community Settings',
                'description' => 'Can manage posting, commenting, and approval settings',
                'category' => 'communities',
                'scope_type' => 'community',
            ],
            [
                'code' => 'community.manage_visibility',
                'name' => 'Manage Community Visibility',
                'description' => 'Can change community visibility',
                'category' => 'communities',
                'scope_type' => 'community',
            ],
            [
                'code' => 'community.manage_sections',
                'name' => 'Manage Community Sections',
                'description' => 'Can create, update, reorder, and delete sections',
                'category' => 'communities',
                'scope_type' => 'community',
            ],
            [
                'code' => 'community.manage_profile',
                'name' => 'Manage Community Profile',
                'description' => 'Can change community profile image, banner, and description',
                'category' => 'communities',
                'scope_type' => 'community',
            ],
            [
                'code' => 'community.transfer_ownership',
                'name' => 'Transfer Ownership',
                'description' => 'Can transfer community ownership',
                'category' => 'communities',
                'scope_type' => 'community',
            ],

            // MEMBERS
            [
                'code' => 'member.view',
                'name' => 'View Members',
                'description' => 'Can view member list',
                'category' => 'members',
                'scope_type' => 'community',
            ],
            [
                'code' => 'member.invite',
                'name' => 'Invite Members',
                'description' => 'Can invite users to the community',
                'category' => 'members',
                'scope_type' => 'community',
            ],
            [
                'code' => 'member.approve_join',
                'name' => 'Approve Join Requests',
                'description' => 'Can approve join requests',
                'category' => 'members',
                'scope_type' => 'community',
            ],
            [
                'code' => 'member.reject_join',
                'name' => 'Reject Join Requests',
                'description' => 'Can reject join requests',
                'category' => 'members',
                'scope_type' => 'community',
            ],
            [
                'code' => 'member.remove',
                'name' => 'Remove Member',
                'description' => 'Can remove members from the community',
                'category' => 'members',
                'scope_type' => 'community',
            ],
            [
                'code' => 'member.ban',
                'name' => 'Ban Member',
                'description' => 'Can ban members',
                'category' => 'members',
                'scope_type' => 'community',
            ],
            [
                'code' => 'member.unban',
                'name' => 'Unban Member',
                'description' => 'Can unban members',
                'category' => 'members',
                'scope_type' => 'community',
            ],
            [
                'code' => 'member.mute',
                'name' => 'Mute Member',
                'description' => 'Can mute members',
                'category' => 'members',
                'scope_type' => 'community',
            ],
            [
                'code' => 'member.unmute',
                'name' => 'Unmute Member',
                'description' => 'Can unmute members',
                'category' => 'members',
                'scope_type' => 'community',
            ],
            [
                'code' => 'member.manage_nicknames',
                'name' => 'Manage Member Nicknames',
                'description' => 'Can manage community nicknames',
                'category' => 'members',
                'scope_type' => 'community',
            ],
            [
                'code' => 'member.manage_profile_overrides',
                'name' => 'Manage Member Community Profiles',
                'description' => 'Can manage member community-specific pictures and profile overrides',
                'category' => 'members',
                'scope_type' => 'community',
            ],

            // ROLES
            [
                'code' => 'role.view',
                'name' => 'View Roles',
                'description' => 'Can view community roles',
                'category' => 'roles',
                'scope_type' => 'community',
            ],
            [
                'code' => 'role.create',
                'name' => 'Create Role',
                'description' => 'Can create roles',
                'category' => 'roles',
                'scope_type' => 'community',
            ],
            [
                'code' => 'role.update',
                'name' => 'Update Role',
                'description' => 'Can update roles',
                'category' => 'roles',
                'scope_type' => 'community',
            ],
            [
                'code' => 'role.delete',
                'name' => 'Delete Role',
                'description' => 'Can delete roles',
                'category' => 'roles',
                'scope_type' => 'community',
            ],
            [
                'code' => 'role.assign',
                'name' => 'Assign Role',
                'description' => 'Can assign roles to users',
                'category' => 'roles',
                'scope_type' => 'community',
            ],
            [
                'code' => 'role.unassign',
                'name' => 'Unassign Role',
                'description' => 'Can remove roles from users',
                'category' => 'roles',
                'scope_type' => 'community',
            ],
            [
                'code' => 'role.manage_permissions',
                'name' => 'Manage Role Permissions',
                'description' => 'Can attach permissions to roles',
                'category' => 'roles',
                'scope_type' => 'community',
            ],

            // MESSAGES
            [
                'code' => 'message.create',
                'name' => 'Send Message',
                'description' => 'Can send messages',
                'category' => 'messages',
                'scope_type' => 'community',
            ],
            [
                'code' => 'message.edit_own',
                'name' => 'Edit Own Message',
                'description' => 'Can edit own messages',
                'category' => 'messages',
                'scope_type' => 'community',
            ],
            [
                'code' => 'message.delete_own',
                'name' => 'Delete Own Message',
                'description' => 'Can delete own messages',
                'category' => 'messages',
                'scope_type' => 'community',
            ],
            [
                'code' => 'message.delete_any',
                'name' => 'Delete Any Message',
                'description' => 'Can delete any messages',
                'category' => 'messages',
                'scope_type' => 'community',
            ],
            [
                'code' => 'message.pin',
                'name' => 'Pin Message',
                'description' => 'Can pin messages',
                'category' => 'messages',
                'scope_type' => 'community',
            ],
            [
                'code' => 'message.unpin',
                'name' => 'Unpin Message',
                'description' => 'Can unpin messages',
                'category' => 'messages',
                'scope_type' => 'community',
            ],
            [
                'code' => 'message.manage_conversations',
                'name' => 'Manage Conversations',
                'description' => 'Can manage conversations in the community context',
                'category' => 'messages',
                'scope_type' => 'community',
            ],

            // MODERATION
            [
                'code' => 'moderation.view_reports',
                'name' => 'View Reports',
                'description' => 'Can view reports',
                'category' => 'moderation',
                'scope_type' => 'community',
            ],
            [
                'code' => 'moderation.resolve_reports',
                'name' => 'Resolve Reports',
                'description' => 'Can resolve reports',
                'category' => 'moderation',
                'scope_type' => 'community',
            ],
            [
                'code' => 'moderation.audit_logs',
                'name' => 'View Audit Logs',
                'description' => 'Can view audit logs',
                'category' => 'moderation',
                'scope_type' => 'community',
            ],
            [
                'code' => 'moderation.manage_sensitive',
                'name' => 'Manage Sensitive Content',
                'description' => 'Can manage sensitive content handling',
                'category' => 'moderation',
                'scope_type' => 'community',
            ],
            [
                'code' => 'moderation.override_locks',
                'name' => 'Override Content Locks',
                'description' => 'Can override post/comment locks',
                'category' => 'moderation',
                'scope_type' => 'community',
            ],

            // SYSTEM
            [
                'code' => 'system.admin_access',
                'name' => 'Admin Access',
                'description' => 'Can access system admin areas',
                'category' => 'system',
                'scope_type' => 'system',
            ],
            [
                'code' => 'system.manage_categories',
                'name' => 'Manage Categories',
                'description' => 'Can create, update, and delete categories',
                'category' => 'system',
                'scope_type' => 'system',
            ],
            [
                'code' => 'system.manage_users',
                'name' => 'Manage Users',
                'description' => 'Can manage users globally',
                'category' => 'system',
                'scope_type' => 'system',
            ],
            [
                'code' => 'system.ban_users',
                'name' => 'Ban Users',
                'description' => 'Can ban users globally',
                'category' => 'system',
                'scope_type' => 'system',
            ],
            [
                'code' => 'system.view_dev_logs',
                'name' => 'View Dev Logs',
                'description' => 'Can view technical logs',
                'category' => 'system',
                'scope_type' => 'system',
            ],
            [
                'code' => 'system.manage_permissions',
                'name' => 'Manage Permissions',
                'description' => 'Can manage the permission registry',
                'category' => 'system',
                'scope_type' => 'system',
            ],
            [
                'code' => 'system.manage_roles',
                'name' => 'Manage System Roles',
                'description' => 'Can manage system-level roles',
                'category' => 'system',
                'scope_type' => 'system',
            ],
        ];

        foreach ($permissions as $permission) {
            Permission::updateOrCreate(
                ['code' => $permission['code']],
                $permission
            );
        }
    }
}
