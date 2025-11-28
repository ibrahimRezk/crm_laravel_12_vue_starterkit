<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // create permissions
        Permission::create(['name' => 'manage users']);
        Permission::create(['name' => 'manage contacts']);
        Permission::create(['name' => 'manage deals']);
        Permission::create(['name' => 'manage tasks']);
        Permission::create(['name' => 'view reports']);

        // create roles and assign created permissions

        // this can be done as separate statements
        $role = Role::create(['name' => 'admin']);
        $role->givePermissionTo(Permission::all());

        $role = Role::create(['name' => 'manager']);
        $role->givePermissionTo(['manage contacts', 'manage deals', 'manage tasks', 'view reports']);

        $role = Role::create(['name' => 'sales_rep']);
        $role->givePermissionTo(['manage contacts', 'manage deals', 'manage tasks']);
    }
}
