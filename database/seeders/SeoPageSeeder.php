<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\SeoPage;

class SeoPageSeeder extends Seeder
{
    /**
     * Static pages that have their own SEO row (admin -> SEO).
     * Dynamic pages (products, collections, blogs, categories, CMS pages)
     * keep their SEO fields on their own tables, so they are not listed here.
     */
    public function run()
    {
        $pages = [
            ['key' => 'home',       'name' => 'Home'],
            ['key' => 'shop',       'name' => 'Shop Page'],
            ['key' => 'categories', 'name' => 'Categories Page'],
            ['key' => 'search',     'name' => 'Search Page'],

            ['key' => 'cart',       'name' => 'Cart Page'],
            ['key' => 'checkout',   'name' => 'Checkout Page'],

            ['key' => 'about',      'name' => 'About Us'],
            ['key' => 'contact',    'name' => 'Contact Us'],

            ['key' => 'blog',       'name' => 'Blog Listing Page'],
            ['key' => 'faq',        'name' => 'FAQ Page'],
        ];

        foreach ($pages as $p) {
            SeoPage::updateOrCreate(
                ['page_key' => $p['key']],
                ['page_name' => $p['name']]
            );
        }
    }
}