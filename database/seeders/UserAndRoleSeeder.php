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

        $role_develop = Role::firstOrCreate(['name' => 'develop'], []);

        $role_admin = Role::firstOrCreate(['name' => 'admin'], []);

        $role_operator = Role::firstOrCreate(['name' => 'operator'], []);

        $user_develop = User::firstOrCreate([
            'email' => 'develop@infinety.es',
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


        $user_admin = User::firstOrCreate([
            'email' => 'admin@infinety.es',
        ], [
            'name' => 'Administrador',
            'password' => Hash::make('password'),
            'email_verified_at' => now(),
            'two_factor_secret' => null,
            'two_factor_recovery_codes' => null,
            'profile_photo_path' => null,
            'current_team_id' => null,
        ]);

        if (!$user_admin->hasRole($role_admin->name))
            $user_admin->assignRole($role_admin->name);

        $user_operator = User::firstOrCreate([
            'email' => 'operador@infinety.es',
        ], [
            'name' => 'Operador',
            'password' => Hash::make('password'),
            'email_verified_at' => now(),
            'two_factor_secret' => null,
            'two_factor_recovery_codes' => null,
            'profile_photo_path' => null,
            'current_team_id' => null,
        ]);

        if (!$user_operator->hasRole($role_operator->name))
            $user_operator->assignRole($role_operator->name);
    }
}
