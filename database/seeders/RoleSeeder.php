<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = [
            [
                'name' => 'super_admin',
                "guard_name"=> "admin",
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'hierarchy' => 1
            ],
            [
                'name'=> 'sub_admin',
                "guard_name"=> "admin",
                'created_at'=> Carbon::now(),
                'updated_at'=> Carbon::now(),
                'hierarchy' => 2
            ],
            [
                'name' => 'admin',
                "guard_name"=> "admin",
                'created_at'=> Carbon::now(),
                'updated_at'=> Carbon::now(),
                'hierarchy' => 3
            ],
            [
                'name' => 'client',
                "guard_name"=> "admin",
                'created_at'=> Carbon::now(),
                'updated_at'=> Carbon::now(),
                'hierarchy' => 4
            ],
            [
                'name' => 'normal_user',
                "guard_name"=> "admin",
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'hierarchy' => 5
            ],
        ];
        Role::insert($roles);

        $super_admin_role  = Role::where('name', 'super_admin')->first();
        $super_admin_role ->givePermissionTo(Permission::all());
    }
}