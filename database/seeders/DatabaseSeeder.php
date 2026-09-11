<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        $manageRooms = Permission::firstOrCreate(['name' => 'manage rooms']);
        $manageTermins = Permission::firstOrCreate(['name' => 'manage termins']);
        $manageUsers = Permission::firstOrCreate(['name' => 'manage users']);
        $manageTrainerTermins = Permission::firstOrCreate(['name' => 'manage termins for trainers']);

        $adminRole = Role::firstOrCreate(['name' => 'admin']);
        $adminRole->syncPermissions([
            $manageRooms,
            $manageTermins,
            $manageTrainerTermins,
            $manageUsers,
        ]);

        $trainerRole = Role::firstOrCreate(['name' => 'trainer']);
        $trainerRole->syncPermissions([
            $manageRooms,
            $manageTermins,
        ]);

        Role::firstOrCreate(['name' => 'user']);
    }
}
