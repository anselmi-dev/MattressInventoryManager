<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class UserAndRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $role_develop = Role::create(['name' => 'develop']);

        $role_admin = Role::create(['name' => 'admin']);

        $role_operator = Role::create(['name' => 'operator']);

        $user_develop = User::firstOrCreate([
            'email' => 'carlos@infinety.es',
        ], [
            'name' => 'develop',
            'password' => Hash::make('password'),
            'email_verified_at' => now(),
            'two_factor_secret' => null,
            'two_factor_recovery_codes' => null,
            'profile_photo_path' => null,
            'current_team_id' => null,
       ]);

        if (!$user_develop->hasRole($role_develop->name))
            $user_develop->assignRole($role_develop->name);
    }
}
