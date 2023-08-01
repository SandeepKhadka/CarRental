<?php

namespace Database\Factories;

use App\Models\Apparel;
use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Category>
 */
class CategoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'title' => fake()->word(),
            'slug' => fake()->unique()->slug(),
            'summary' => fake()->sentences(3,true),
            'image' => fake()->imageUrl('100','100'),
            'is_parent' => fake()->randomElement([true,false]),
            'status' => fake()->randomElement(['active','inactive']),
            'parent_id' => fake()->randomElement(Category::pluck('id')->toArray()),
            'apparel' => fake()->randomElement(Apparel::pluck('id')->toArray()),
        ];
    }
}
