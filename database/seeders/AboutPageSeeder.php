<?php

namespace Database\Seeders;

use App\Models\AboutBelief;
use App\Models\AboutPage;
use App\Models\AboutStat;
use Illuminate\Database\Seeder;

class AboutPageSeeder extends Seeder
{
    public function run(): void
    {
        AboutPage::updateOrCreate(['id' => 1], [
            'meta_title'       => 'About Us | Aparatus Pastime - Made for Play. Built for Memories.',
            'meta_description' => 'Discover the story behind Aparatus Pastime. Our commitment to wholesome play, curious minds, and screen-free family adventures.',

            'hero_badge'           => 'OUR STORY & VALUES',
            'hero_title'           => 'MADE FOR PLAY.',
            'hero_title_highlight' => 'BUILT FOR MEMORIES.',
            'hero_description'     => 'At Aparatus Pastime, we believe the best childhood memories happen outdoors, around family game tables, and through curious, open-ended hands-on discovery.',

            'story_badge'       => 'HOW IT STARTED',
            'story_heading'     => 'Why We Started Aparatus Pastime',
            'story_paragraph_1' => 'In a fast-paced world filled with flashing screens and disposable plastic novelties, we found that parents were searching for toys and games that encourage real, meaningful play.',
            'story_paragraph_2' => 'Aparatus Pastime was created to give parents, teachers, and gift buyers a trustworthy destination for premium, non-toxic, and engaging toys, board games, and sports equipment that spark imagination and bring families closer together.',
            'story_image'       => 'https://images.unsplash.com/photo-1596461404969-9ae70f2830c1?auto=format&fit=crop&w=1000&q=80',
            'story_image_alt'   => 'Kids playing with blocks',

            'beliefs_badge'       => 'CORE PHILOSOPHY',
            'beliefs_heading'     => 'What We Believe',
            'beliefs_description' => 'Every product we curate is guided by four foundational principles of healthy child development.',

            'promise_badge'       => 'OUR PROMISE',
            'promise_heading'     => 'Toys Made For Real Play & Big Smiles',
            'promise_description' => 'If an item ever fails to delight you or your little explorer, our 7-day easy replacement policy and dedicated customer support team have you covered.',
            'promise_btn1_text'   => 'EXPLORE THE COLLECTION →',
            'promise_btn1_url'    => '/shop',
            'promise_btn2_text'   => 'CONTACT US',
            'promise_btn2_url'    => '/contact',
        ]);

        if (AboutStat::count() === 0) {
            AboutStat::insert([
                ['value' => '100%',    'label' => 'Child-Safe Materials', 'color' => 'navy',   'sort_order' => 1, 'status' => 1, 'created_at' => now(), 'updated_at' => now()],
                ['value' => 'Curated', 'label' => 'Zero-Clutter Quality', 'color' => 'orange', 'sort_order' => 2, 'status' => 1, 'created_at' => now(), 'updated_at' => now()],
            ]);
        }

        if (AboutBelief::count() === 0) {
            AboutBelief::insert([
                ['title' => 'PLAY MATTERS',    'icon' => 'fa-shapes',                'color' => 'orange', 'sort_order' => 1, 'status' => 1, 'description' => 'Play is how children understand the world, experiment safely, and build self-confidence.', 'created_at' => now(), 'updated_at' => now()],
                ['title' => 'LEARN MATTERS',   'icon' => 'fa-atom',                  'color' => 'mint',   'sort_order' => 2, 'status' => 1, 'description' => 'Curiosity turns into lifelong problem-solving skills when learning is tactile, visual, and fun.', 'created_at' => now(), 'updated_at' => now()],
                ['title' => 'MOVE MATTERS',    'icon' => 'fa-person-running',        'color' => 'blue',   'sort_order' => 3, 'status' => 1, 'description' => 'Active sports and fresh air foster strong bodies, motor coordination, and good team spirit.', 'created_at' => now(), 'updated_at' => now()],
                ['title' => 'QUALITY MATTERS', 'icon' => 'fa-wand-magic-sparkles',   'color' => 'yellow', 'sort_order' => 4, 'status' => 1, 'description' => 'We never compromise on safety, non-toxic materials, or durability that lasts for years.', 'created_at' => now(), 'updated_at' => now()],
            ]);
        }
    }
}