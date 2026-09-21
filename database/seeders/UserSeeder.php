<?php

namespace Database\Seeders;

use App\Models\Admin;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'customer',
            'email' => 'customer@store.com',
            'password' => Hash::make('123456789'),
        ]);

        Admin::create([
            'name' => 'Super Admin',
            'email' => 'super.admin@store.com',
            'password' => Hash::make('123456789'),
            'role' => Admin::ROLE_SUPER_ADMIN,
            'status' => Admin::STATUS_ACTIVE,
        ]);
    }
}