<?php

namespace Database\Seeders;
// namespace Database\Seeders\UsSeeder;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            UserSeeder::class,
            ApparelSeeder::class
        ]);
        \App\Models\Category::factory(20)->create();
        \App\Models\Brand::factory(10)->create();
        \App\Models\Product::factory(50)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
    }
}
