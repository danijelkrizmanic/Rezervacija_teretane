<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        Permission::create(['name' => 'manage rooms']);
        Permission::create(['name' => 'manage termins']);
        Permission::create(['name' => 'manage users']);
        Permission::create(['name' => 'manage termins for trainers']);

        $adminRole = Role::create(['name' => 'admin']);
        $adminRole->givePermissionTo('manage rooms');
        $adminRole->givePermissionTo('manage termins');
        $adminRole->givePermissionTo('manage termins for trainers');
        $adminRole->givePermissionTo('manage users');

        $trainerRole = Role::create(['name' => 'trainer']);
        $trainerRole->givePermissionTo('manage termins');

        $userRole = Role::create(['name' => 'user']);
    }
}
