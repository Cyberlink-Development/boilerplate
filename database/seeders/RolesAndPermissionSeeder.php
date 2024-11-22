<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesAndPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // $permissions = Permission::get();

        // $super_admin_role = Role::create(['name'=>'Super Admin', "guard_name"=>"admin"]);

        // foreach($permissions as $permission){
        //     $super_admin_role->givePermissionTo($permission);
        // }

        $super_admin_role = Role::where('name', 'super_admin')->first();
        $super_admin_role->givePermissionTo(Permission::all());
    }
}
