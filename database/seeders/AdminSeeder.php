<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->updateOrInsert(
            ['email' => 'jala@example.com'],
            [
                'username' => 'Jala',
                'password' => bcrypt('jala2001'),
                'updated_at' => now(),
                'created_at' => now(),
            ]
        );

        $user = DB::table('users')
            ->where('email', 'jala@example.com')
            ->first();

        $role = DB::table('roles')
            ->where('name', 'super_admin')
            ->where('scope_type', 'system')
            ->first();

        if (! $user || ! $role) {
            return;
        }

        DB::table('user_roles')->updateOrInsert(
            [
                'user_id' => $user->id,
                'role_id' => $role->id,
                'community_id' => null,
            ],
            [
                'assigner_user_id' => null,
                'status' => 'active',
                'updated_at' => now(),
                'created_at' => now(),
            ]
        );
    }
}