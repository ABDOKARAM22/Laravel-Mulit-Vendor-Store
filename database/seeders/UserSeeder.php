<?php

namespace Database\Seeders;

use App\Models\Admin;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
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
        'name' => 'Abdelrahman',
        'email'=> 'AbdelrahmanKaram22@gmail.com',
        'password'=> Hash::make('123456789'),
        ]);
        Admin::create([
        'name' => 'Admin',
        'email'=> 'super.admin@store.com',
        'password'=> Hash::make('123456789'),
        'role'=> 'super_admin',
        ]);
    }
}
