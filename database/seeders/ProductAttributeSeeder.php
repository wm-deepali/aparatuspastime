<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ProductAttributeSeeder extends Seeder
{
    /**
     * Seeds attributes, their values, category assignment and the
     * product attribute values for the 3 PPT products.
     * Run AFTER ProductSeeder and AFTER the add_icon_to_attributes_table
     * migration. Safe to re-run.
     *
     * ⚠ ASSUMED COLUMNS (adjust if your migrations differ):
     *   attributes               : name, slug, icon, status
     *   attribute_values         : attribute_id, value, status
     *   product_attribute_values : product_id, attribute_id, attribute_value_id
     *   category_attributes      : columns from the CategoryAttribute model
     *   (all tables assumed to have created_at / updated_at)
     *
     * These are plain spec attributes (not variants), so every variant /
     * dependency flag is false.
     */
    public function run(): void
    {
        // attribute slug => [name, FontAwesome 6 icon class]
        $attributes = [
            'colour'   => ['Colour',             'fa-solid fa-palette'],
            'size'     => ['Size',               'fa-solid fa-ruler-combined'],
            'material' => ['Material',           'fa-solid fa-cubes'],
            'origin'   => ['Origin',             'fa-solid fa-earth-asia'],
            'players'  => ['Players',            'fa-solid fa-users'],
            'battery'  => ['Electrical/Battery', 'fa-solid fa-battery-half'],
            'usage'    => ['Usage',              'fa-solid fa-puzzle-piece'],
            'facility' => ['Facility',           'fa-solid fa-box-open'],
        ];

        // product slug => [category slug, attribute values]
        $data = [
            'ludo-snakes-ladders' => ['board-games', [
                'colour'   => 'Multi Colour',
                'size'     => '36cm x 36cm',
                'material' => 'Cardboard & Plastic',
                'origin'   => 'India',
                'players'  => '2 to 4',
                'battery'  => 'No',
                'usage'    => 'All time family entertainer',
                'facility' => 'Open box inspection',
            ]],
            'stunt-car' => ['toys-games', [
                'colour'   => 'Multi Colour',
                'size'     => '18cm x 12cm x 4cm',
                'material' => 'Plastic',
                'origin'   => 'India',
                'battery'  => 'No',
                'usage'    => 'Kids fun',
                'facility' => 'Open box inspection',
            ]],
            'crazy-speed-motor-bike' => ['toys-games', [
                'colour'   => 'Blue',
                'size'     => '15cm x 7cm x 7cm',
                'material' => 'Plastic',
                'origin'   => 'India',
                'battery'  => 'No',
                'usage'    => 'Kids fun',
                'facility' => 'Open box inspection',
            ]],
        ];

        // 1. Attributes (name + icon)
        $attrIds = [];
        foreach ($attributes as $slug => [$name, $icon]) {
            $attrIds[$slug] = $this->upsertRow('attributes', ['slug' => $slug], [
                'name'   => $name,
                'icon'   => $icon,
                'status' => 1,
            ]);
        }

        // 2. Attribute values (one option per distinct value)
        $valueIds = [];
        foreach ($data as [$categorySlug, $values]) {
            foreach ($values as $attrSlug => $value) {
                $valueIds[$attrSlug][$value] ??= $this->upsertRow('attribute_values', [
                    'attribute_id' => $attrIds[$attrSlug],
                    'value'        => $value,
                ], ['status' => 1]);
            }
        }

        // 3. Assign attributes to categories (spec-only, no variant flags)
        $categoryAttrs = [];
        foreach ($data as [$categorySlug, $values]) {
            foreach (array_keys($values) as $attrSlug) {
                $categoryAttrs[$categorySlug][$attrSlug] = true;
            }
        }

        foreach ($categoryAttrs as $categorySlug => $attrSlugs) {
            $categoryId = DB::table('categories')->where('slug', $categorySlug)->value('id');
            if (!$categoryId) {
                $this->command?->warn("Category '{$categorySlug}' not found - skipped");
                continue;
            }

            $sort = 1;
            foreach (array_keys($attributes) as $attrSlug) {
                if (!isset($attrSlugs[$attrSlug])) {
                    continue;
                }

                $this->upsertRow('category_attributes', [
                    'category_id'  => $categoryId,
                    'attribute_id' => $attrIds[$attrSlug],
                ], [
                    'is_required'      => 0,
                    'used_for_variant' => 0,
                    'is_selectable'    => 0,
                    'price_dependent'  => 0,
                    'image_dependent'  => 0,
                    'stock_dependent'  => 0,
                    'sku_dependent'    => 0,
                    'show_in_filter'   => 0,
                    'show_on_listing'  => 0,
                    'sort_order'       => $sort++,
                    'status'           => 1,
                ]);
            }
        }

        // 4. Product attribute values
        foreach ($data as $productSlug => [$categorySlug, $values]) {
            $productId = DB::table('products')->where('slug', $productSlug)->value('id');
            if (!$productId) {
                $this->command?->warn("Product '{$productSlug}' not found - run ProductSeeder first");
                continue;
            }

            DB::table('product_attribute_values')->where('product_id', $productId)->delete();

            foreach ($attributes as $attrSlug => $meta) {
                if (!isset($values[$attrSlug])) {
                    continue;
                }

                DB::table('product_attribute_values')->insert([
                    'product_id'         => $productId,
                    'attribute_id'       => $attrIds[$attrSlug],
                    'attribute_value_id' => $valueIds[$attrSlug][$values[$attrSlug]],
                    'created_at'         => now(),
                    'updated_at'         => now(),
                ]);
            }
        }
    }

    /**
     * Insert or update a row matched by $match; returns its id.
     */
    private function upsertRow(string $table, array $match, array $data): int
    {
        $now = now();

        if (DB::table($table)->where($match)->exists()) {
            DB::table($table)->where($match)->update($data + ['updated_at' => $now]);
        } else {
            DB::table($table)->insert($match + $data + ['created_at' => $now, 'updated_at' => $now]);
        }

        return (int) DB::table($table)->where($match)->value('id');
    }
}