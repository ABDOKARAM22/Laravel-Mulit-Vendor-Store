<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\Store;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $name = fake()->name();
        return [
            'name' => $name,
            'slug' => str::slug($name),
            'description' => fake()->sentence(),
            'image' => fake()->imageUrl(600,600),
            'price' => fake()->randomFloat(1,1,999),
            'compare_price' => fake()->randomFloat(1,1000,1500),
            'featured' => rand(0,1),
            'store_id' => Store::InRandomOrder()->first()->id,
            'category_id' => Category::InRandomOrder()->first()->id,
        ];
    }
}
