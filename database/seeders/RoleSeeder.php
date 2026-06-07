<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $roles = [
            [
                'creator_user_id' => null,
                'community_id' => null,
                'name' => 'super_admin',
                'scope_type' => 'system',
            ],
            [
                'creator_user_id' => null,
                'community_id' => null,
                'name' => 'admin',
                'scope_type' => 'system',
            ],
            [
                'creator_user_id' => null,
                'community_id' => null,
                'name' => 'moderator',
                'scope_type' => 'system',
            ],
            [
                'creator_user_id' => null,
                'community_id' => null,
                'name' => 'member',
                'scope_type' => 'system',
            ],
            [
                'creator_user_id' => null,
                'community_id' => null,
                'name' => 'user',
                'scope_type' => 'system',
            ],
        ];

        foreach ($roles as $role) {
            Role::updateOrCreate(
                [
                    'community_id' => $role['community_id'],
                    'name' => $role['name'],
                ],
                $role
            );
        }
    }
}
