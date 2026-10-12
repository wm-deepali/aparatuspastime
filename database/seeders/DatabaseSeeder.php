<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(FaqSeeder::class);
        $this->call(UserSeeder::class);
        $this->call(BlogSeeder::class);
        $this->call(ProductSeeder::class);
        $this->call(CategorySeeder::class);
        $this->call(AboutPageSeeder::class);
        $this->call(DynamicPageSeeder::class);
        $this->call(HomeContentSeeder::class);
        $this->call(ProductAttributeSeeder::class);
        $this->call(IndiaStatesCitiesSeeder::class);
    }
}
