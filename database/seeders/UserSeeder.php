<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Carbon;


class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = [
            [
                'name'=> 'School',
                'email'=> 'school@gmail.com',
                'email_verified_at'=> Carbon::now(),
                'phone' => '9876543210',
                'password'=> Hash::make('admin@admin'),
                'active'=> 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]
        ];
        User::insert($user);
    }
}
