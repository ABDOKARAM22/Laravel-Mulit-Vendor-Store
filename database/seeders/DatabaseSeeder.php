<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Admin;
use App\Models\Store;
use App\Models\Product;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Category;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory(5)->create();

        // User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        Store::factory(10)->create();
        Category::factory(15)->create();
        Product::factory(150)->create();
        $this->call(UserSeeder::class);
        Admin::factory()->count(5)->create();

    }
}
