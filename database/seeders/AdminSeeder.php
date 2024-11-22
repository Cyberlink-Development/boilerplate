<?php

namespace Database\Seeders;

use App\Models\Admin;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admins = [
            [
                'name' => 'Super Admin',
                'email' => 'super_admin@gmail.com',
                'role' => 'super_admin',
                'u_id' => 0,
            ],
            [
                'name' => 'Sub Admin',
                'email' => 'sub_admin@gmail.com',
                'role' => 'sub_admin',
                'u_id' => 1,
            ],
        ];
        $now = Carbon::now();
        foreach ($admins as $adminData) {
            $admin = Admin::create([
                'name' => $adminData['name'],
                'u_id' => $adminData['u_id'],
                'email' => $adminData['email'],
                'email_verified_at' => $now,
                'password' => Hash::make('admin@admin'),
                'pin' => 1322,
                'active' => 1,
                'created_at' => $now,
                'updated_at' => $now,
            ]);

            $admin->assignRole($adminData['role']);
        }
    }
}
