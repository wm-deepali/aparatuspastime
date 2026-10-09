<?php

namespace Database\Seeders;

use App\Models\Collection;
use Illuminate\Database\Seeder;

class CollectionSeeder extends Seeder
{
    public function run(): void
    {
        $collections = [
            ['code' => 'new_arrival', 'name' => 'New Arrivals', 'sort_order' => 1],
            ['code' => 'best_seller', 'name' => 'Best Sellers', 'sort_order' => 2],
            ['code' => 'trending', 'name' => 'Trending', 'sort_order' => 3],
            ['code' => 'current_favourite', 'name' => 'Our Current Favourites', 'sort_order' => 4],
        ];
        foreach ($collections as $c) {
            Collection::updateOrCreate(
                ['code' => $c['code']],
                $c + [
                    'slug' => $c['code'],
                    'status' => 1,
                    'is_system' => true,
                ]
            );
        }
    }
}