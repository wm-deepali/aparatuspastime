<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    /**
     * Seeds parent categories + sub-categories.
     * Safe to re-run: matches on slug (including soft-deleted rows),
     * so it updates instead of duplicating.
     *
     * NOTE: these are sample values. Replace names, descriptions, icons,
     * and sub-categories with the ones from assets/js/data/categories.js.
     * Images are left empty - upload them from the admin panel
     * (or set 'image' => 'assets/images/xyz.jpg' for a file in /public).
     */
    public function run(): void
    {
        $categories = [
            [
                'name'        => 'Toys & Games',
                'sub_title'   => 'Fun for every age',
                'description' => 'Classic toys, building sets, puzzles and imaginative play that keep little hands busy.',
                'icon'        => 'fa-puzzle-piece',
                'pastel_bg'   => 'bg-soft-blue',
                'is_popular'  => 1,
                'is_featured' => 1,
                'children'    => ['Building Blocks', 'Puzzles', 'Dolls & Plush', 'Remote Control Toys'],
            ],
            [
                'name'        => 'Board Games',
                'sub_title'   => 'Strategy, family & party games',
                'description' => 'Thoughtful strategy games and family favourites that bring everyone to the table.',
                'icon'        => 'fa-chess-knight',
                'pastel_bg'   => 'bg-soft-orange',
                'is_popular'  => 1,
                'is_featured' => 0,
                'children'    => ['Strategy Games', 'Family Games', 'Card Games', 'Party Games'],
            ],
            [
                'name'        => 'Sports Gear',
                'sub_title'   => 'High-energy play',
                'description' => 'Balls, bats, rackets and athletic essentials for young champions.',
                'icon'        => 'fa-futbol',
                'pastel_bg'   => 'bg-soft-yellow',
                'is_popular'  => 1,
                'is_featured' => 1,
                'children'    => ['Football', 'Cricket', 'Badminton', 'Skating'],
            ],
            [
                'name'        => 'Outdoor Adventure',
                'sub_title'   => 'Explore the outdoors',
                'description' => 'Bikes, camping gear and garden play to get kids outside and exploring.',
                'icon'        => 'fa-tree',
                'pastel_bg'   => 'bg-soft-blue',
                'is_popular'  => 0,
                'is_featured' => 0,
                'children'    => ['Camping Gear', 'Bikes & Scooters', 'Garden Play', 'Water Toys'],
            ],
            [
                'name'        => 'STEM Kits',
                'sub_title'   => 'Learn by building',
                'description' => 'Science, coding and robotics kits designed to foster lifelong curiosity.',
                'icon'        => 'fa-flask',
                'pastel_bg'   => 'bg-soft-orange',
                'is_popular'  => 1,
                'is_featured' => 1,
                'children'    => ['Science Experiments', 'Robotics', 'Coding Toys', 'Electronics Kits'],
            ],
            [
                'name'        => 'Arts & Crafts',
                'sub_title'   => 'Create something new',
                'description' => 'Colouring, painting and DIY craft sets for creative little minds.',
                'icon'        => 'fa-palette',
                'pastel_bg'   => 'bg-soft-yellow',
                'is_popular'  => 0,
                'is_featured' => 0,
                'children'    => ['Drawing & Colouring', 'Painting Sets', 'DIY Craft Kits', 'Clay & Dough'],
            ],
        ];

        foreach ($categories as $index => $data) {
            $children = $data['children'];
            unset($data['children']);

            $parent = $this->upsert(array_merge($data, [
                'parent_id'  => null,
                'sort_order' => $index + 1,
            ]));

            foreach ($children as $childIndex => $childName) {
                $this->upsert([
                    'name'       => $childName,
                    'parent_id'  => $parent->id,
                    'sort_order' => $childIndex + 1,
                ]);
            }
        }
    }

    /**
     * Create or update a category by slug (restores it if soft-deleted).
     */
    private function upsert(array $data): Category
    {
        $data['slug'] = $data['slug'] ?? Str::slug($data['name']);

        $slug = $data['slug'];
        unset($data['slug']);

        $category = Category::withTrashed()->updateOrCreate(
            ['slug' => $slug],
            array_merge([
                'status'          => 1,
                'added_by'        => 'Seeder',
                'is_sub_category' => empty($data['parent_id']) ? 0 : 1,
                'is_popular'      => 0,
                'is_featured'     => 0,
                'show_in_navbar'  => 0,
            ], $data)
        );

        if ($category->trashed()) {
            $category->restore();
        }

        return $category;
    }
}