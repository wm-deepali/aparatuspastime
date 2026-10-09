<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Collection;
use App\Models\InvoiceSetting;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Traits\LogsApiCalls;
use App\Models\HomeSlider;
use App\Models\HomeUsp;
use App\Models\HomeInterest;
use App\Models\HomeFeature;
use App\Models\HomeTestimonial;
use App\Models\HomeSection;
use App\Models\Blog;

class FrontController extends Controller
{
    use LogsApiCalls;

    // Age filter groups → overlap against products.age_min / age_max (max null = no upper limit)
    private const AGE_GROUPS = [
        '0-2' => ['label' => '0–2 Years (Little Discoverers)', 'min' => 0, 'max' => 2],
        '3-5' => ['label' => '3–5 Years (Curious Explorers)', 'min' => 3, 'max' => 5],
        '6-8' => ['label' => '6–8 Years (Active Adventurers)', 'min' => 6, 'max' => 8],
        '9-12' => ['label' => '9–12 Years (Creative Thinkers)', 'min' => 9, 'max' => 12],
        '12+' => ['label' => '12+ Years (Big Kids & Teens)', 'min' => 12, 'max' => null],
    ];

    private const PRICE_RANGES = [
        'all' => ['label' => 'All Prices', 'min' => null, 'max' => null],
        '0-500' => ['label' => 'Under ₹500', 'min' => null, 'max' => 500],
        '500-1000' => ['label' => '₹500 – ₹1,000', 'min' => 500, 'max' => 1000],
        '1000-2000' => ['label' => '₹1,000 – ₹2,000', 'min' => 1000, 'max' => 2000],
        '2000+' => ['label' => '₹2,000 & Above', 'min' => 2000, 'max' => null],
    ];

    private const RATINGS = [
        'all' => 'Any Rating',
        '4.5' => '4.5 Stars & Above ★',
        '4.0' => '4.0 Stars & Above ★',
    ];

    private const SORTS = ['featured', 'newest', 'price-low', 'price-high', 'rating'];


    public function home(Request $request)
    {
        // ── Admin-managed home content ──
        $sliders = HomeSlider::where('status', 1)->orderBy('sort_order')->get();
        $usps = HomeUsp::where('status', 1)->orderBy('sort_order')->get();
        $features = HomeFeature::where('status', 1)->orderBy('sort_order')->get();
        $testimonials = HomeTestimonial::where('status', 1)->orderBy('sort_order')->get();
        $sections = HomeSection::all()->keyBy('section_key');

        // Interests: resolve link (category slug or custom link) here, so the view stays simple
        $interests = HomeInterest::where('status', 1)->orderBy('sort_order')->get();
        $interestSlugs = Category::whereIn('id', $interests->pluck('category_id')->filter()->unique())
            ->pluck('slug', 'id');

        $interests->each(function ($i) use ($interestSlugs) {
            $i->link = $i->category_id && isset($interestSlugs[$i->category_id])
                ? url('shop') . '?category=' . $interestSlugs[$i->category_id]
                : $i->custom_link;
        });

        // ── Categories ──
        $categories = Category::query()
            ->whereNull('parent_id')
            ->withCount('products')
            ->orderBy('sort_order')
            ->take(7)
            ->get();

        // ── Trending tabs ──
        $codes = ['new_arrival', 'best_seller', 'trending'];
        $collections = Collection::whereIn('code', $codes)->where('status', 1)->get()->keyBy('code');

        $trendingTabs = [];
        foreach ($codes as $code) {
            $trendingTabs[$code] = isset($collections[$code])
                ? $collections[$code]->products()
                    ->visible()
                    ->with(['images', 'category', 'collections'])
                    ->orderBy('products.sort_order')
                    ->latest('products.id')
                    ->take(8)
                    ->get()
                : collect();
        }

        // ── Our Current Favourites (2 products) ──
        $favourites = Collection::where('code', 'current_favourite')->where('status', 1)->first()
                ?->products()
            ->visible()
            ->with(['images', 'category', 'collections'])
            ->orderBy('products.sort_order')
            ->latest('products.id')
            ->take(2)
            ->get() ?? collect();

        // ── Two category spotlight sections (featured first, then sort order) ──
        $spotlightCategories = Category::active()
            ->parents()
            ->whereHas('products', fn($q) => $q->visible())
            ->with(['children' => fn($q) => $q->active()->ordered()])
            ->orderByDesc('is_featured')
            ->ordered()
            ->take(2)
            ->get();

        $productsFor = fn(Category $cat) => $cat->products()
            ->visible()
            ->with(['images', 'category', 'collections'])
            ->orderBy('sort_order')
            ->latest('id')
            ->take(4)
            ->get();

        $spotlightCategory = $spotlightCategories->get(0);
        $spotlightProducts = $spotlightCategory ? $productsFor($spotlightCategory) : collect();

        $secondCategory = $spotlightCategories->get(1);
        $secondProducts = $secondCategory ? $productsFor($secondCategory) : collect();

        $blogs = Blog::published()
            ->where('show_home', 1)
            ->latest('published_at')
            ->latest('id')
            ->take(3)
            ->get();

        return view('front-pages.home', compact(
            'sliders',
            'usps',
            'interests',
            'features',
            'testimonials',
            'sections',
            'categories',
            'trendingTabs',
            'favourites',
            'spotlightCategory',
            'spotlightProducts',
            'secondCategory',
            'secondProducts',
            'blogs'
        ));
    }

    public function shop(Request $request)
    {
        // "+" in a URL (?age=12+) arrives as a space, so put it back
        $clean = fn($v) => str_replace(' ', '+', trim((string) $v));

        $catSlugs = array_values(array_filter(array_map($clean, (array) $request->query('category', []))));
        $ages = array_values(array_intersect(
            array_map($clean, (array) $request->query('age', [])),
            array_keys(self::AGE_GROUPS)
        ));

        $priceKey = $clean($request->query('price', 'all'));
        if (!isset(self::PRICE_RANGES[$priceKey])) {
            $priceKey = 'all';
        }
        $minPrice = self::PRICE_RANGES[$priceKey]['min'];
        $maxPrice = self::PRICE_RANGES[$priceKey]['max'];

        // Header links like ?maxPrice=499 still work
        if ($priceKey === 'all') {
            $minPrice = is_numeric($request->query('minPrice')) ? (float) $request->query('minPrice') : null;
            $maxPrice = is_numeric($request->query('maxPrice')) ? (float) $request->query('maxPrice') : null;
        }

        $rating = (string) $request->query('rating', 'all');
        if (!isset(self::RATINGS[$rating])) {
            $rating = 'all';
        }

        $sort = in_array($request->query('sort'), self::SORTS) ? $request->query('sort') : 'featured';

        // Collection filter (?filter=bestseller → collections.slug)
        $collectionSlug = $request->query('filter');

        $query = Product::visible()->with(['category', 'images', 'collections']);

        // Category — selecting a parent also includes its subcategories
        if ($catSlugs) {
            $selected = Category::active()->whereIn('slug', $catSlugs)->get();
            $ids = $selected->pluck('id')
                ->merge(Category::whereIn('parent_id', $selected->pluck('id'))->pluck('id'))
                ->unique();

            $query->where(function ($q) use ($ids) {
                $q->whereIn('category_id', $ids)->orWhereIn('subcategory_id', $ids);
            });
        }

        // Age — overlap of [age_min, age_max] with the chosen group(s)
        if ($ages) {
            $query->where(function ($q) use ($ages) {
                foreach ($ages as $key) {
                    $gMin = self::AGE_GROUPS[$key]['min'];
                    $gMax = self::AGE_GROUPS[$key]['max'];

                    $q->orWhere(function ($w) use ($gMin, $gMax) {
                        $w->whereNotNull('age_min');
                        if ($gMax !== null) {
                            $w->where('age_min', '<=', $gMax);
                        }
                        $w->where(function ($x) use ($gMin) {
                            $x->whereNull('age_max')->orWhere('age_max', '>=', $gMin);
                        });
                    });
                }
            });
        }

        if ($minPrice !== null)
            $query->where('price', '>=', $minPrice);
        if ($maxPrice !== null)
            $query->where('price', '<=', $maxPrice);

        if ($rating !== 'all') {
            $query->where('rating_avg', '>=', (float) $rating);
        }

        if ($collectionSlug) {
            $query->whereHas('collections', fn($q) => $q->where('slug', $collectionSlug));
        }

        match ($sort) {
            'price-low' => $query->orderBy('price')->orderByDesc('id'),
            'price-high' => $query->orderByDesc('price')->orderByDesc('id'),
            'rating' => $query->orderByDesc('rating_avg')->orderByDesc('reviews_count'),
            'newest' => $query->orderByDesc('id'),
            default => $query->orderBy('sort_order')->orderByDesc('id'),
        };

        $products = $query->paginate(12)->withQueryString();

        $categories = Category::active()
            ->parents()
            ->with(['children' => fn($q) => $q->active()->ordered()])
            ->withCount('products')
            ->ordered()
            ->get();

        // Single selected category → used for the page heading
        $activeCategory = count($catSlugs) === 1
            ? Category::active()->where('slug', $catSlugs[0])->first()
            : null;

        return view('front-pages.shop', [
            'products' => $products,
            'categories' => $categories,
            'activeCategory' => $activeCategory,
            'catSlugs' => $catSlugs,
            'ages' => $ages,
            'ageGroups' => self::AGE_GROUPS,
            'priceKey' => $priceKey,
            'priceRanges' => self::PRICE_RANGES,
            'rating' => $rating,
            'ratings' => self::RATINGS,
            'sort' => $sort,
            'collectionSlug' => $collectionSlug,
        ]);
    }

    public function categories()
    {
        $categories = Category::active()
            ->parents()
            ->with([
                'children' => fn($q) => $q->active()->ordered(),
            ])
            ->withCount('products')
            ->ordered()
            ->get();

        return view('front-pages.categories', compact('categories'));
    }

    public function productDetail(Request $request, $slug = null)
    {
        $slug = $slug ?? $request->query('slug');

        $product = Product::visible()
            ->where('slug', $slug)
            ->with([
                'category',
                'subcategory',
                'images',
                'collections',
                'includedItems',
                'benefits',
                'highlights',
                'attributeValues.attribute',
                'attributeValues.value',
            ])
            ->firstOrFail();

        // Card relations (used by front-pages.partials.product-card)
        $cardRelations = ['category', 'images', 'collections'];

        // ── Related products: same category / subcategory first ──────────
        $related = Product::visible()
            ->where('id', '!=', $product->id)
            ->where(function ($q) use ($product) {
                $q->where('category_id', $product->category_id);

                if ($product->subcategory_id) {
                    $q->orWhere('subcategory_id', $product->subcategory_id);
                }
            })
            ->with($cardRelations)
            ->latest()
            ->take(4)
            ->get();

        // Not enough in the same category → top up with other visible products
        if ($related->count() < 4) {
            $extra = Product::visible()
                ->where('id', '!=', $product->id)
                ->whereNotIn('id', $related->pluck('id'))
                ->with($cardRelations)
                ->latest()
                ->take(4 - $related->count())
                ->get();

            $related = $related->concat($extra)->values();
        }

        // ── Recently viewed (session, newest first) ──────────────────────
        $viewedIds = collect(session('recently_viewed', []))
            ->reject(fn($id) => (int) $id === $product->id)
            ->values();

        $recentlyViewed = collect();

        if ($viewedIds->isNotEmpty()) {
            $recentlyViewed = Product::visible()
                ->whereIn('id', $viewedIds)
                ->with($cardRelations)
                ->get()
                ->sortBy(fn($p) => $viewedIds->search($p->id))   // keep "most recent first" order
                ->take(4)
                ->values();
        }

        // Push the current product to the front of the list (max 10 kept)
        session([
            'recently_viewed' => collect([$product->id])
                ->merge($viewedIds)
                ->unique()
                ->take(10)
                ->values()
                ->all(),
        ]);

        // Tax wording ("Inclusive of all GST" / exclusive) comes from Invoice Settings.
        $invoice_setting = InvoiceSetting::first();

        return view('front-pages.product', compact('product', 'related', 'recentlyViewed', 'invoice_setting'));
    }

    public function quickView($id)
    {
        $product = Product::visible()
            ->with(['category', 'images', 'collections'])
            ->findOrFail($id);

        $images = $product->images
            ->sortByDesc('is_default')
            ->values()
            ->map(fn($i) => asset('storage/' . $i->image))
            ->all();

        $badge = $product->collections->first(fn($c) => filled($c->badge_text));
        $hasDiscount = $product->mrp > $product->price;
        $minQty = max(1, (int) $product->min_qty);

        return response()->json([
            'id' => $product->id,
            'name' => $product->name,
            'url' => url('product') . '?slug=' . $product->slug,
            'category' => $product->category->name ?? null,
            'age_label' => $product->age_label,
            'rating' => (float) $product->rating_avg,
            'reviews_count' => (int) $product->reviews_count,
            'price' => (float) $product->price,
            'mrp' => $hasDiscount ? (float) $product->mrp : null,
            'discount' => $hasDiscount ? round((($product->mrp - $product->price) / $product->mrp) * 100) : 0,
            'short_description' => \Illuminate\Support\Str::limit(
                strip_tags($product->short_description ?: $product->description),
                170
            ),
            'stock' => (int) $product->stock,
            'in_stock' => $product->stock > 0,
            'min_qty' => $minQty,
            'images' => $images,
            'badge' => $badge ? ['text' => $badge->badge_text, 'color' => $badge->badge_color] : null,
        ]);
    }

    public function blogs(Request $request)
    {
        $cat = $request->query('cat');
        $tag = $request->query('tag');

        $query = Blog::published()->latest('published_at')->latest('id');

        if ($cat) {
            $query->where('category_slug', $cat);
        }
        if ($tag) {
            $query->whereJsonContains('tags', $tag);
        }

        // Featured banner only on the unfiltered page
        $featured = (!$cat && !$tag)
            ? Blog::published()->orderByDesc('is_featured')->latest('published_at')->latest('id')->first()
            : null;

        $blogs = $query->paginate(9)->withQueryString();

        $topics = Blog::published()
            ->whereNotNull('category')
            ->select('category', 'category_slug')
            ->distinct()
            ->orderBy('category')
            ->get();

        return view('front-pages.blogs', compact('blogs', 'featured', 'topics', 'cat', 'tag'));
    }

    public function blogShow($slug)
    {
        $blog = Blog::published()->where('slug', $slug)->firstOrFail();

        // Count one view per session
        $viewed = session('viewed_blogs', []);
        if (!in_array($blog->id, $viewed)) {
            Blog::whereKey($blog->id)->increment('views_count');
            $blog->views_count++;
            session(['viewed_blogs' => array_merge($viewed, [$blog->id])]);
        }

        // Newer / older story (by id)
        $prevBlog = Blog::published()->where('id', '>', $blog->id)->orderBy('id')->first();
        $nextBlog = Blog::published()->where('id', '<', $blog->id)->orderByDesc('id')->first();

        // Related: same category first
        $related = Blog::published()
            ->where('id', '!=', $blog->id)
            ->orderByRaw('(category_slug = ?) desc', [$blog->category_slug])
            ->latest('published_at')
            ->take(3)
            ->get();

        $trending = Blog::published()->orderByDesc('views_count')->take(5)->get();

        $topics = Blog::published()
            ->whereNotNull('category')
            ->select('category', 'category_slug')
            ->distinct()
            ->orderBy('category')
            ->get();

        // Products picked in admin for this article
        $ids = $blog->recommended_product_ids ?? [];
        $sideProducts = $ids
            ? Product::visible()->with(['category', 'images'])->whereIn('id', $ids)->take(3)->get()
            : collect();

        return view('front-pages.blog-detail', compact(
            'blog',
            'prevBlog',
            'nextBlog',
            'related',
            'trending',
            'topics',
            'sideProducts'
        ));
    }

}