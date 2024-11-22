<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions = [
            "roles_index",
            "roles_show",
            "roles_create",
            "roles_edit",
            "roles_delete",
            "permissions_index",
            "permissions_show",
            "permissions_create",
            "permissions_edit",
            "permissions_delete",
            "admins_index",
            "admins_show",
            "admins_create",
            "admins_edit",
            "admins_delete",
            "has_backend",
            "roles_and_permissions",
            "site_settings",
        ];


        foreach($permissions as $permission){
            Permission::create([
                "name" => $permission,
                "guard_name" => "admin",
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]);
        }

        $roles = Role::get();
        foreach($roles as $role){
            $role->givePermissionTo('has_backend');
            $role->givePermissionTo('site_settings');
        }
    }
}
