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
                'name' => 'Admin',
                'email' => 'admin@gmail.com',
                'role' => 'admin',
            ],
        ];
        $now = Carbon::now();
        foreach ($admins as $adminData) {
            $admin = Admin::create([
                'name' => $adminData['name'],
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
