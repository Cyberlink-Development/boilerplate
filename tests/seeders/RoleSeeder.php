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
                'updated_at' => Carbon::now()
            ],
            [
                'name'=> 'sub_admin',
                "guard_name"=> "admin",
                'created_at'=> Carbon::now(),
                'updated_at'=> Carbon::now()
            ],
            [
                'name' => 'admin',
                "guard_name"=> "admin",
                'created_at'=> Carbon::now(),
                'updated_at'=> Carbon::now()
            ],
            [
                'name' => 'client',
                "guard_name"=> "admin",
                'created_at'=> Carbon::now(),
                'updated_at'=> Carbon::now()
            ],
            [
                'name' => 'normal_user',
                "guard_name"=> "admin",
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
        ];
        Role::insert($roles);

        $super_admin_role  = Role::where('name', 'super_admin')->first();
        $super_admin_role ->givePermissionTo(Permission::all());
    }
}