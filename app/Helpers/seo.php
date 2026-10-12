<?php

use App\Models\SeoPage;
use App\Models\Blog;
use App\Models\Product;
use App\Models\Collection;
use App\Models\Category;
use App\Models\DynamicPage;

if (!function_exists('getSeo')) {

    /**
     * Returns the model / SeoPage row that holds the SEO fields
     * (meta_title, meta_description, ...) for the current front-end route.
     */
    function getSeo()
    {
        $route = optional(request()->route())->getName();
        $slug = request()->route('slug');

        switch ($route) {

            // /collections/{slug}
            case 'collections.show':
                return Collection::where('slug', $slug)->first();

            // /blog-detail/{slug}
            case 'blog.show':
                return Blog::where('slug', $slug)->first();

            // /product/{slug?}
            case 'product':
                return $slug ? Product::where('slug', $slug)->first() : null;

            // /page/{slug}  (CMS pages: policies, terms, etc.)
            case 'page.show':
                return DynamicPage::where('slug', $slug)->first();

            // /shop  -> category SEO when filtered by ?category=slug, else the Shop page row
            case 'shop':
                $categorySlug = request('category');

                if (is_string($categorySlug) && $categorySlug !== '') {
                    $category = Category::where('slug', $categorySlug)->first();

                    if ($category) {
                        return $category;
                    }
                }

                return SeoPage::where('page_key', 'shop')->first();

            default:
                // route name => seo_pages.page_key
                $map = [
                    'home'       => 'home',
                    'categories' => 'categories',
                    'search'     => 'search',
                    'cart'       => 'cart',
                    'checkout'   => 'checkout',
                    'about'      => 'about',
                    'contact'    => 'contact',
                    'blogs'      => 'blog',
                    'faq'        => 'faq',
                ];

                $key = $map[$route] ?? 'home';

                return SeoPage::where('page_key', $key)->first();
        }
    }
}