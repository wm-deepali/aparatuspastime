<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
{
    /**
     * Seeds the 3 products from the client PPT:
     * Ludo, Snakes & Ladders / Stunt Car / Crazy Speed Motor Bike.
     *
     * Safe to re-run: matches on slug and updates instead of duplicating
     * (restores soft-deleted rows). Uses the query builder so it does not
     * depend on the Product model's $fillable.
     *
     * Attributes (Colour, Size, Material...) are seeded separately by
     * ProductAttributeSeeder - run this one first.
     *
     * NOTE: `stock` is NOT in the PPT. 50 is only a placeholder.
     * Benefits, care text and highlights below are PLACEHOLDERS built from
     * the PPT descriptions - edit them from the admin panel.
     * `is_non_toxic` is left at its default (off) - tick it in the admin only
     * for products that are actually certified.
     * Images are not seeded - upload them from the admin panel.
     */
    public function run(): void
    {
        // Categories must exist first (idempotent)
        $this->call(CategorySeeder::class);

        $products = [
            [
                'name'              => 'Ludo, Snakes & Ladders',
                'category'          => 'board-games',
                'subcategory'       => 'family-games',
                'short_description' => 'All-time family entertainer board for 2 to 4 players.',
                'description'       => '<p>Ludo, Snakes & Ladders in one board, made of cardboard and plastic. A classic game the whole family can enjoy together, for 2 to 4 players.</p>',
                'mrp'               => 305,
                'discount'          => 50,
                'age_min'           => 6,
                'hsn_code'          => null,
                'benefits'          => [
                    ['Team Play',           'fa-solid fa-users'],
                    ['Family Bonding',      'fa-solid fa-people-roof'],
                    ['Counting & Strategy', 'fa-solid fa-dice'],
                ],
                'highlights'        => [
                    ['Two Classics, One Board', 'Ludo and Snakes & Ladders together on a single board.', 'fa-solid fa-dice'],
                    ['For 2 to 4 Players',      'A game the whole family can enjoy together.',            'fa-solid fa-users'],
                    ['Cardboard & Plastic',     'Made of cardboard and plastic.',                         'fa-solid fa-cubes'],
                ],
            ],
            [
                'name'              => 'Stunt Car',
                'category'          => 'toys-games',
                'subcategory'       => null,
                'short_description' => 'Multi-colour plastic stunt car for kids.',
                'description'       => '<p>A fun multi-colour plastic stunt car for kids aged 3 and above. No batteries needed.</p>',
                'mrp'               => 180,
                'discount'          => 30,
                'age_min'           => 3,
                'hsn_code'          => '950300',
                'benefits'          => [
                    ['Motor Skills',      'fa-solid fa-hand-holding-heart'],
                    ['Imaginative Play',  'fa-solid fa-wand-magic-sparkles'],
                ],
                'highlights'        => [
                    ['Multi-Colour Design', 'A fun multi-colour plastic stunt car.', 'fa-solid fa-palette'],
                    ['No Batteries Needed', 'Works without batteries.',              'fa-solid fa-battery-empty'],
                    ['Ages 3 and Above',    'Made for kids aged 3 and above.',       'fa-solid fa-child'],
                ],
            ],
            [
                'name'              => 'Crazy Speed Motor Bike',
                'category'          => 'toys-games',
                'subcategory'       => null,
                'short_description' => 'Blue plastic toy motor bike for kids.',
                'description'       => '<p>A blue plastic toy motor bike for kids aged 3 and above. No batteries needed.</p>',
                'mrp'               => 120,
                'discount'          => 20,
                'age_min'           => 3,
                'hsn_code'          => null,
                'benefits'          => [
                    ['Motor Skills',      'fa-solid fa-hand-holding-heart'],
                    ['Imaginative Play',  'fa-solid fa-wand-magic-sparkles'],
                ],
                'highlights'        => [
                    ['Blue Toy Motor Bike', 'A blue plastic toy motor bike for kids.', 'fa-solid fa-motorcycle'],
                    ['No Batteries Needed', 'Works without batteries.',                'fa-solid fa-battery-empty'],
                    ['Ages 3 and Above',    'Made for kids aged 3 and above.',         'fa-solid fa-child'],
                ],
            ],
        ];

        $deliveryTime = '2 to 7 days';

        // Care & Setup section (single textarea) - placeholder text
        $howToUse = '<p>Store in a clean dry place after play. Wipe with a clean cloth.</p>';

        // Shipping & Returns section (single textarea) - delivery time lives here too
        $deliveryReturns = '<p><strong>Delivery:</strong> ' . $deliveryTime . '.</p>'
                         . '<p><strong>Return / Replacement:</strong> Not applicable.</p>'
                         . '<p><strong>Guarantee / Warranty:</strong> Not applicable.</p>';

        foreach ($products as $index => $p) {
            $categoryId = DB::table('categories')->where('slug', $p['category'])->value('id');

            if (!$categoryId) {
                $this->command?->warn("Category '{$p['category']}' not found - skipped {$p['name']}");
                continue;
            }

            $subcategoryId = $p['subcategory']
                ? DB::table('categories')->where('slug', $p['subcategory'])->value('id')
                : null;

            $productId = $this->upsertRow('products', ['slug' => Str::slug($p['name'])], [
                'category_id'       => $categoryId,
                'subcategory_id'    => $subcategoryId,
                'name'              => $p['name'],
                'hsn_code'          => $p['hsn_code'],
                'short_description' => $p['short_description'],
                'description'       => $p['description'],
                'how_to_use'        => $howToUse,
                'delivery_returns'  => $deliveryReturns,
                'mrp'               => $p['mrp'],
                'discount_type'     => 'amount',
                'discount'          => $p['discount'],
                'price'             => $p['mrp'] - $p['discount'],
                'stock'             => 50,                 // placeholder - not in PPT
                'min_qty'           => 1,
                'delivery_time'     => $deliveryTime,
                'delivery_charge'   => 100,
                'age_min'           => $p['age_min'],
                'age_max'           => null,               // "3+", "6+" = no upper limit
                'sort_order'        => $index + 1,
                'status'            => 1,
                'deleted_at'        => null,               // restores soft-deleted rows
            ]);

            // Developmental Benefits chips: [title, icon]
            $this->replaceChildren('product_benefits', $productId, array_map(
                fn ($b) => ['title' => $b[0], 'icon' => $b[1]],
                $p['benefits']
            ));

            // Overview highlight cards: [title, description, icon]
            $this->replaceChildren('product_highlights', $productId, array_map(
                fn ($h) => ['title' => $h[0], 'description' => $h[1], 'icon' => $h[2]],
                $p['highlights']
            ));
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

    /**
     * Replace a product's child rows (benefits / highlights) so re-running the
     * seeder never duplicates them. Row order = sort_order.
     */
    private function replaceChildren(string $table, int $productId, array $rows): void
    {
        $now = now();

        DB::table($table)->where('product_id', $productId)->delete();

        foreach (array_values($rows) as $i => $row) {
            DB::table($table)->insert($row + [
                'product_id' => $productId,
                'sort_order' => $i,
                'created_at' => $now,
                'updated_at' => $now,
            ]);
        }
    }
}