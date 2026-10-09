<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class HomeContentSeeder extends Seeder
{
    public function run(): void
    {
        $now = now();
        $stamp = fn(array $rows) => array_map(
            fn($r) => $r + ['created_at' => $now, 'updated_at' => $now],
            $rows
        );

        /* ── 1. Hero slider ── */
        if (DB::table('home_sliders')->count() === 0) {
            DB::table('home_sliders')->insert($stamp([
                [
                    'image' => 'https://images.unsplash.com/photo-1596461404969-9ae70f2830c1?auto=format&fit=crop&w=2000&q=85',
                    'image_alt' => 'Kids playing with colorful toys',
                    'badge_text' => 'EXPLORE & IMAGINE • PLAYTIME SPECIALS',
                    'badge_icon' => 'fa-sparkles',
                    'badge_color' => 'orange',
                    'title_line1' => 'BIG FUN',
                    'title_line2' => 'STARTS HERE',
                    'highlight_color' => 'yellow',
                    'description' => 'Discover toys, games and activities made for curious little minds. Built for joyful discovery, creativity, and lasting childhood memories.',
                    'btn1_text' => 'SHOP TOYS →',
                    'btn1_link' => '/shop?category=toys',
                    'btn2_text' => 'EXPLORE ALL CATEGORIES',
                    'btn2_link' => '/categories',
                    'nav_label' => 'TOYS',
                    'sort_order' => 1,
                    'status' => 1,
                ],
                [
                    'image' => 'https://images.unsplash.com/photo-1587654780291-39c9404d746b?auto=format&fit=crop&w=2000&q=85',
                    'image_alt' => 'STEM Learning & Magnetic Sets',
                    'badge_text' => 'CURIOUS MINDS • STEM & DISCOVERY',
                    'badge_icon' => 'fa-atom',
                    'badge_color' => 'mint',
                    'title_line1' => 'PLAY. LEARN.',
                    'title_line2' => 'EXPLORE.',
                    'highlight_color' => 'mint',
                    'description' => 'From STEM kits to creative games, find something that sparks curiosity, hands-on problem solving, and imagination.',
                    'btn1_text' => 'EXPLORE LEARNING →',
                    'btn1_link' => '/shop?category=educational',
                    'btn2_text' => 'TRENDING NOW',
                    'btn2_link' => '/shop?filter=trending',
                    'nav_label' => 'STEM',
                    'sort_order' => 2,
                    'status' => 1,
                ],
                [
                    'image' => 'https://images.unsplash.com/photo-1517649763962-0c623266ddc0?auto=format&fit=crop&w=2000&q=85',
                    'image_alt' => 'Active outdoor kids sports',
                    'badge_text' => 'GET ACTIVE • OUTDOOR GEAR',
                    'badge_icon' => 'fa-volleyball',
                    'badge_color' => 'sky',
                    'title_line1' => 'GET OUT &',
                    'title_line2' => 'PLAY',
                    'highlight_color' => 'sky',
                    'description' => 'Active games and sports gear for little adventurers. Build coordination, cardiovascular agility, and team spirit.',
                    'btn1_text' => 'SHOP OUTDOOR PLAY →',
                    'btn1_link' => '/shop?category=outdoor',
                    'btn2_text' => 'SPORTS GEAR',
                    'btn2_link' => '/shop?category=sports',
                    'nav_label' => 'OUTDOOR',
                    'sort_order' => 3,
                    'status' => 1,
                ],
                [
                    'image' => 'https://images.unsplash.com/photo-1549465220-1a8b9238cd48?auto=format&fit=crop&w=2000&q=85',
                    'image_alt' => 'Curated toy gift boxes',
                    'badge_text' => 'BIRTHDAYS & SURPRISES',
                    'badge_icon' => 'fa-gift',
                    'badge_color' => 'orange',
                    'title_line1' => 'THE PERFECT',
                    'title_line2' => 'GIFT',
                    'highlight_color' => 'yellow',
                    'description' => 'Fun finds for birthdays, celebrations and every special moment. Curated bundles that make unboxing unforgettable.',
                    'btn1_text' => 'SHOP GIFTS →',
                    'btn1_link' => '/shop?category=gifts',
                    'btn2_text' => 'TOP BEST SELLERS',
                    'btn2_link' => '/shop?filter=bestseller',
                    'nav_label' => 'GIFTS',
                    'sort_order' => 4,
                    'status' => 1,
                ],
            ]));
        }

        /* ── 2. USP strip ── */
        if (DB::table('home_usps')->count() === 0) {
            DB::table('home_usps')->insert($stamp([
                ['icon' => 'fa-shield-halved', 'title' => 'SAFE & QUALITY PRODUCTS', 'subtitle' => '100% Non-toxic & child-safe', 'color' => 'blue', 'sort_order' => 1, 'status' => 1],
                ['icon' => 'fa-truck', 'title' => 'FAST DELIVERY', 'subtitle' => 'Free on orders above ₹999', 'color' => 'orange', 'sort_order' => 2, 'status' => 1],
                ['icon' => 'fa-lock', 'title' => 'SECURE PAYMENTS', 'subtitle' => 'UPI, Cards & Net Banking', 'color' => 'mint', 'sort_order' => 3, 'status' => 1],
                ['icon' => 'fa-rotate-left', 'title' => 'EASY RETURNS', 'subtitle' => 'Hassle-free 7-day policy', 'color' => 'yellow', 'sort_order' => 4, 'status' => 1],
            ]));
        }

        /* ── 3. Shop by interest ── */
        if (DB::table('home_interests')->count() === 0) {
            $rows = [
                ['icon' => 'fa-cubes', 'title' => 'BUILD', 'subtitle' => 'Blocks & Magnetics', 'color' => 'orange', 'slug' => 'toys'],
                ['icon' => 'fa-paintbrush', 'title' => 'CREATE', 'subtitle' => 'Art & Craft Kits', 'color' => 'yellow', 'slug' => 'activity'],
                ['icon' => 'fa-person-running', 'title' => 'MOVE', 'subtitle' => 'Football & Sports', 'color' => 'blue', 'slug' => 'sports'],
                ['icon' => 'fa-brain', 'title' => 'THINK', 'subtitle' => 'Puzzles & Tactics', 'color' => 'purple', 'slug' => 'games'],
                ['icon' => 'fa-flask', 'title' => 'DISCOVER', 'subtitle' => 'STEM Science Labs', 'color' => 'mint', 'slug' => 'educational'],
                ['icon' => 'fa-trophy', 'title' => 'COMPETE', 'subtitle' => 'Lawn Tournaments', 'color' => 'coral', 'slug' => 'outdoor'],
            ];

            $insert = [];
            foreach ($rows as $i => $r) {
                $catId = DB::table('categories')->where('slug', $r['slug'])->value('id');
                $insert[] = [
                    'icon' => $r['icon'],
                    'title' => $r['title'],
                    'subtitle' => $r['subtitle'],
                    'color' => $r['color'],
                    'category_id' => $catId,
                    'custom_link' => $catId ? null : '/shop?category=' . $r['slug'],
                    'sort_order' => $i + 1,
                    'status' => 1,
                ];
            }
            DB::table('home_interests')->insert($stamp($insert));
        }

        /* ── 4. Why families love us ── */
        if (DB::table('home_features')->count() === 0) {
            DB::table('home_features')->insert($stamp([
                ['icon' => 'fa-award', 'title' => 'QUALITY YOU CAN TRUST', 'description' => 'Certified non-toxic, BPA-free materials that withstand active play.', 'color' => 'blue', 'sort_order' => 1, 'status' => 1],
                ['icon' => 'fa-child-reaching', 'title' => 'MADE FOR REAL PLAY', 'description' => 'Open-ended kits that encourage real movement, thought, and discovery.', 'color' => 'orange', 'sort_order' => 2, 'status' => 1],
                ['icon' => 'fa-truck-fast', 'title' => 'FAST & RELIABLE DELIVERY', 'description' => 'Safely packed with express tracking straight to your doorstep.', 'color' => 'yellow', 'sort_order' => 3, 'status' => 1],
                ['icon' => 'fa-rotate-left', 'title' => 'EASY RETURNS', 'description' => '7-day replacement guarantee so you shop with 100% confidence.', 'color' => 'mint', 'sort_order' => 4, 'status' => 1],
                ['icon' => 'fa-heart', 'title' => 'CAREFULLY CURATED PICKS', 'description' => 'Only items we would proudly give to our own kids and families.', 'color' => 'purple', 'sort_order' => 5, 'status' => 1],
            ]));
        }

        /* ── 5. Testimonials ── */
        if (DB::table('home_testimonials')->count() === 0) {
            DB::table('home_testimonials')->insert($stamp([
                [
                    'customer_name' => 'Pooja Sharma', 'customer_title' => 'Parent of 2, Bengaluru',
                    'review' => 'The Magnetic 3D Tiles kept our 5-year-old completely engaged for hours without touching an iPad. The plastic quality is top-notch with smooth edges and vibrant colors.',
                    'rating' => 5, 'product_tag' => 'Magnetic 3D Tiles', 'tag_icon' => 'fa-shapes',
                    'color' => 'yellow', 'is_verified' => 1, 'sort_order' => 1, 'status' => 1,
                ],
                [
                    'customer_name' => 'Vikram Mehta', 'customer_title' => 'Dad & Youth Coach, Mumbai',
                    'review' => 'We bought the Match Pro football and cricket starter kit for the weekend park games. Excellent craftsmanship, balanced weight, and the included pump made it a great gift.',
                    'rating' => 5, 'product_tag' => 'Match Pro Football', 'tag_icon' => 'fa-futbol',
                    'color' => 'blue', 'is_verified' => 1, 'sort_order' => 2, 'status' => 1,
                ],
                [
                    'customer_name' => 'Neha & Rohan K.', 'customer_title' => 'Family Game Night, Delhi',
                    'review' => 'Kingdoms & Conquests became our Friday family tradition. Clear instructions, solid wooden components, and great fun for teenagers and adults alike.',
                    'rating' => 5, 'product_tag' => 'Board Game Night', 'tag_icon' => 'fa-chess-knight',
                    'color' => 'mint', 'is_verified' => 1, 'sort_order' => 3, 'status' => 1,
                ],
                [
                    'customer_name' => 'Ananya Deshmukh', 'customer_title' => 'Early Educator & Mom, Pune',
                    'review' => 'As an early educator, child safety is paramount. Aparatus toys exceeded every expectation—non-toxic organic finish, zero sharp corners, and superb tactile learning!',
                    'rating' => 5, 'product_tag' => 'Wooden Sensory Train', 'tag_icon' => 'fa-cubes',
                    'color' => 'orange', 'is_verified' => 1, 'sort_order' => 4, 'status' => 1,
                ],
                [
                    'customer_name' => 'Siddharth Roy', 'customer_title' => 'Tech Dad, Kolkata',
                    'review' => 'The Solar STEM Robotics kit was a huge surprise. My 7-year-old constructed motorized rovers with real working solar panels. Highly recommended for curious minds!',
                    'rating' => 5, 'product_tag' => 'Solar STEM Rover', 'tag_icon' => 'fa-atom',
                    'color' => 'purple', 'is_verified' => 1, 'sort_order' => 5, 'status' => 1,
                ],
                [
                    'customer_name' => 'Kavita & Amit Patel', 'customer_title' => 'Parents of Twins, Ahmedabad',
                    'review' => 'Lightning fast shipping and delightful gift wrap! The badminton racquets are lightweight yet durable for our 10-year-old twins. Outdoor play is now their favorite part of the day.',
                    'rating' => 5, 'product_tag' => 'Pro Badminton Kit', 'tag_icon' => 'fa-medal',
                    'color' => 'sky', 'is_verified' => 1, 'sort_order' => 6, 'status' => 1,
                ],
            ]));
        }

        /* ── 6. Section headings (one row per section_key) ── */
        $sections = [
            'categories' => [
                'badge_text' => 'DISCOVER PLAYTIME', 'badge_icon' => 'fa-sparkles',
                'title' => 'WHAT DO THEY LOVE?',
                'subtitle' => 'Explore fun, games and activities for every kind of kid.',
            ],
            'trending' => [
                'badge_text' => 'HOTTEST PICKS',
                'title' => "THEY'RE LOVING THESE",
                'subtitle' => 'Popular picks for playtime and family smiles.',
                'button_text' => 'DISCOVER ALL PRODUCTS', 'button_link' => '/shop',
            ],
            'favourites' => [
                'badge_text' => 'HANDPICKED STANDOUTS',
                'title' => 'OUR CURRENT FAVOURITES',
                'subtitle' => 'Two timeless play sets designed for endless creativity and hours of smiles.',
            ],
            'interests' => [
                'badge_text' => 'PASSION & HOBBIES',
                'title' => 'WHAT ARE THEY INTO?',
                'subtitle' => 'Follow their curiosity with curated interest-based collections.',
            ],
            'promo_banner' => [
                'badge_text' => 'SEASON OF ADVENTURE',
                'title' => 'MORE PLAY.', 'title_highlight' => 'MORE MEMORIES.',
                'subtitle' => 'Discover something exciting for their next adventure. From backyard championships to living room board game triumphs.',
                'button_text' => 'SHOP NOW →', 'button_link' => '/shop',
            ],
            'why_us' => [
                'badge_text' => 'OUR COMMITMENT',
                'title' => 'WHY FAMILIES LOVE US',
                'subtitle' => 'Crafting wholesome play experiences with trusted quality and honest care.',
            ],
            'testimonials' => [
                'badge_text' => 'HAPPY FAMILIES', 'badge_icon' => 'fa-face-smile',
                'title' => 'WHAT PARENTS ARE SAYING',
                'subtitle' => 'Real feedback from families and educators who made playtime memorable.',
                'extra' => json_encode(['rating' => '4.9/5', 'reviews' => '(1,200+ Reviews)']),
            ],
        ];

        foreach ($sections as $key => $data) {
            $exists = DB::table('home_sections')->where('section_key', $key)->exists();
            if ($exists) {
                continue; // don't overwrite what admin already edited
            }
            DB::table('home_sections')->insert($data + [
                'section_key' => $key,
                'status' => 1,
                'created_at' => $now,
                'updated_at' => $now,
            ]);
        }
    }
}