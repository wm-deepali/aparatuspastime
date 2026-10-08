<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use App\Models\Product;
use App\Models\Category;
use App\Models\CategoryAttribute;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use App\Models\ProductImage;
use App\Models\ProductVideo;
use App\Models\ProductAddon;
use App\Models\ProductAttributeValue;
use App\Models\ProductVariant;
use App\Models\ProductVariantValue;
use App\Models\ProductVariantImage;
use App\Models\Collection;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\Format;

class ProductController extends Controller
{
    /**
     * The four independent variant "types". Each is generated from a
     * different subset of category attributes (whichever attributes have
     * the matching *_dependent flag turned on), and stored as its own
     * set of ProductVariant rows tagged with this type.
     */
    protected const VARIANT_TYPES = ['price', 'image', 'stock', 'sku'];

    /**
     * ✅ Compress & store an uploaded image as WebP — generates BOTH a
     * full-size version (for detail/gallery views) and a thumb version
     * (for grid cards / listing pages), so listing pages don't have to
     * download the full 1200px image just to shrink it via CSS.
     *
     * Returns ['full' => path, 'thumb' => path] — both already stored
     * on the public disk.
     */
    private function compressAndStore(
        UploadedFile $file,
        string $folder,
        int $maxWidth = 1200,
        int $thumbWidth = 400,
        int $quality = 80
    ): array {
        $manager = ImageManager::usingDriver(Driver::class);

        $uuid = Str::uuid();
        $folder = trim($folder, '/');

        // ---- Full size ----
        $image = $manager->decode($file);

        if ($image->width() > $maxWidth) {
            $image->scale(width: $maxWidth);
        }

        $encodedFull = $image->encodeUsingFormat(Format::WEBP, quality: $quality);

        $fullPath = $folder . '/' . $uuid . '.webp';

        Storage::disk('public')->put($fullPath, (string) $encodedFull);

        // ---- Thumb size (decode fresh so we don't compound scaling) ----
        $thumbImage = $manager->decode($file);

        if ($thumbImage->width() > $thumbWidth) {
            $thumbImage->scale(width: $thumbWidth);
        }

        $encodedThumb = $thumbImage->encodeUsingFormat(Format::WEBP, quality: $quality);

        $thumbPath = $folder . '/' . $uuid . '_thumb.webp';

        Storage::disk('public')->put($thumbPath, (string) $encodedThumb);

        return [
            'full' => $fullPath,
            'thumb' => $thumbPath,
        ];
    }

    public function index(Request $request)
    {
        $query = Product::with('images');

        // Categories dropdown
        $categories = Category::whereNull('parent_id')
            ->orderBy('name')
            ->get();

        // Subcategories dropdown
        $subCategories = collect();

        if ($request->filled('category_id')) {
            $subCategories = Category::where('parent_id', $request->category_id)
                ->orderBy('name')
                ->get();
        }

        // Search
        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        // Category Filter
        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        // Sub Category Filter
        if ($request->filled('subcategory_id')) {
            $query->where('subcategory_id', $request->subcategory_id);
        }

        // Sorting
        $sortBy = $request->get('sort_by', 'id');
        $sortOrder = $request->get('sort_order', 'desc');

        $allowedSorts = [
            'id',
            'name',
            'price',
            'status'
        ];

        if (in_array($sortBy, $allowedSorts)) {
            $query->orderBy($sortBy, $sortOrder);
        }

        $products = $query
            ->paginate(10)
            ->appends($request->all());

        return view('admin.products.index', compact(
            'products',
            'categories',
            'subCategories'
        ));
    }

    public function create()
    {
        $categories = Category::whereNull('parent_id')
            ->where('status', 1)
            ->orderBy('name')
            ->get();

        $collections = Collection::where('status', 1)
            ->orderBy('sort_order')
            ->get();

        return view('admin.products.create', compact(
            'categories',
            'collections'
        ));
    }

    public function subcategories(Category $category)
    {
        return response()->json(

            Category::where('parent_id', $category->id)
                ->where('status', 1)
                ->orderBy('name')
                ->get([
                    'id',
                    'name'
                ])

        );
    }

    public function categoryAttributes(Category $category)
    {
        $attributes = CategoryAttribute::with([
            'attribute.values'
        ])
            ->where('category_id', $category->id)
            ->where('status', 1)
            ->orderBy('sort_order')
            ->get();

        return response()->json($attributes);
    }

    /*
    |--------------------------------------------------------------------------
    | Shared validation + payload (store & update use the same fields)
    |--------------------------------------------------------------------------
    */

    private function validateProduct(Request $request): void
    {
        $iconRule = ['nullable', 'string', 'max:100', 'regex:/^[a-z0-9\- ]+$/i'];

        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|string|max:255',
            'mrp' => 'nullable|numeric|min:0',
            'discount' => 'nullable|numeric|min:0',
            'discount_type' => 'nullable|in:amount,percentage',
            'price' => 'nullable|numeric|min:0',
            'stock' => 'nullable|integer|min:0',
            'min_qty' => 'nullable|integer|min:1',
            'sku' => 'nullable|string|max:255',
            'product_code' => 'nullable|string|max:255',
            'hsn_code' => 'nullable|string|max:20',
            'delivery_time' => 'nullable|string|max:255',
            'delivery_charge' => 'nullable|numeric|min:0',
            'age_min' => 'nullable|integer|min:0|max:99',
            'age_max' => 'nullable|integer|min:0|max:99',
            'sort_order' => 'nullable|integer|min:0',
            'is_non_toxic' => 'nullable|boolean',
            'images.*' => 'nullable|image|max:2048',

            // videos + addon options
            'videos.*' => 'nullable|mimes:mp4,webm,mov,avi|max:20480',
            'addons.*.detail' => 'nullable|string|max:255',
            'addons.*.price' => 'nullable|numeric|min:0',

            // what's in the box / benefits / highlights
            'included_items.*.title' => 'nullable|string|max:255',
            'benefits.*.title' => 'nullable|string|max:255',
            'benefits.*.icon' => $iconRule,
            'highlights.*.title' => 'nullable|string|max:255',
            'highlights.*.description' => 'nullable|string|max:1000',
            'highlights.*.icon' => $iconRule,

            // multiple images per image-type variant + per-image delete
            'variants_image.*.images.*' => 'nullable|image|max:2048',
            'delete_variant_images.*' => 'nullable|integer',
        ]);

        if (
            $request->filled('age_min') && $request->filled('age_max')
            && (int) $request->age_max < (int) $request->age_min
        ) {
            throw ValidationException::withMessages([
                'age_max' => 'Age "To" cannot be less than "From".',
            ]);
        }
    }

    /**
     * Columns shared by create & update. Slug is handled separately
     * (store generates one, update only regenerates when it changed).
     */
    private function productData(Request $request): array
    {
        $num = fn ($v, $default = 0) => ($v !== null && $v !== '') ? $v : $default;

        return [
            'category_id' => $request->category_id,
            'subcategory_id' => $request->subcategory_id ?: null,
            'name' => $request->name,

            'short_description' => $request->short_description,
            'description' => $request->description,
            'how_to_use' => $request->how_to_use,
            'delivery_returns' => $request->delivery_returns,

            // blank MRP/Discount/Price never get written as '' into decimal columns
            'mrp' => $num($request->mrp),
            'discount_type' => $request->discount_type ?: 'amount',
            'discount' => $num($request->discount),
            'price' => $num($request->price, $request->mrp ?: 0),

            'sku' => $request->sku,
            'product_code' => $request->product_code,
            'hsn_code' => $request->hsn_code,

            'stock' => $num($request->stock),
            'min_qty' => $num($request->min_qty, 1),

            'delivery_time' => $request->delivery_time,
            'delivery_charge' => $num($request->delivery_charge),

            // age_max NULL = no upper limit ("3+")
            'age_min' => $request->filled('age_min') ? (int) $request->age_min : null,
            'age_max' => $request->filled('age_max') ? (int) $request->age_max : null,

            'is_non_toxic' => $request->boolean('is_non_toxic'),
            'sort_order' => $num($request->sort_order),

            'meta_title' => $request->meta_title,
            'meta_description' => $request->meta_description,

            'status' => (int) $request->input('status', 1),
        ];
    }

    /**
     * Replace a product's child rows (included items / benefits / highlights)
     * with the submitted set. Blank-title rows are skipped; submitted order
     * becomes sort_order.
     */
    private function syncRows(Product $product, string $relation, array $rows, array $fields): void
    {
        $product->$relation()->delete();

        $sort = 0;

        foreach ($rows as $row) {
            if (blank($row['title'] ?? null)) {
                continue;
            }

            $data = [];
            foreach ($fields as $field) {
                $data[$field] = trim((string) ($row[$field] ?? '')) ?: null;
            }

            $product->$relation()->create($data + ['sort_order' => $sort++]);
        }
    }

    private function syncContentRows(Request $request, Product $product): void
    {
        $this->syncRows($product, 'includedItems', $request->input('included_items', []), ['title']);
        $this->syncRows($product, 'benefits', $request->input('benefits', []), ['title', 'icon']);
        $this->syncRows($product, 'highlights', $request->input('highlights', []), ['title', 'icon', 'description']);
    }

    public function store(Request $request)
    {
        $this->validateProduct($request);

        DB::beginTransaction();

        try {

            $product = Product::create(
                $this->productData($request) + [
                    'slug' => $request->slug
                        ? $this->generateUniqueSlug($request->slug)
                        : $this->generateUniqueSlug($request->name),
                ]
            );

            /*
            |--------------------------------------------------------------------------
            | Product Images
            |--------------------------------------------------------------------------
            */

            if ($request->hasFile('images')) {

                foreach ($request->file('images') as $index => $image) {

                    $paths = $this->compressAndStore(
                        $image,
                        'products'
                    );

                    ProductImage::create([
                        'product_id' => $product->id,
                        'image' => $paths['full'],
                        'thumb' => $paths['thumb'],
                        'is_default' => $request->default_image == $index ? 1 : 0,
                    ]);
                }

                $this->ensureDefaultImage($product);
            }

            /*
            |--------------------------------------------------------------------------
            | Product Videos
            |--------------------------------------------------------------------------
            */

            if ($request->hasFile('videos')) {

                foreach ($request->file('videos') as $video) {

                    $path = $video->store(
                        'product-videos',
                        'public'
                    );

                    ProductVideo::create([
                        'product_id' => $product->id,
                        'video' => $path,
                    ]);
                }
            }

            /*
            |--------------------------------------------------------------------------
            | Addon Options
            |--------------------------------------------------------------------------
            */

            foreach ($request->input('addons', []) as $addon) {

                if (empty($addon['detail'])) {
                    continue;
                }

                ProductAddon::create([
                    'product_id' => $product->id,
                    'detail' => $addon['detail'],
                    'price' => ($addon['price'] ?? '') !== '' ? $addon['price'] : 0,
                ]);
            }

            /*
            |--------------------------------------------------------------------------
            | What's In The Box / Developmental Benefits / Overview Highlights
            |--------------------------------------------------------------------------
            */

            $this->syncContentRows($request, $product);

            /*
            |--------------------------------------------------------------------------
            | Product Attributes
            |--------------------------------------------------------------------------
            */

            if ($request->filled('attribute_values')) {

                foreach ($request->attribute_values as $attributeId => $values) {

                    foreach ($values as $valueId) {

                        ProductAttributeValue::create([
                            'product_id' => $product->id,
                            'attribute_id' => $attributeId,
                            'attribute_value_id' => $valueId,
                        ]);
                    }
                }
            }

            /*
            |--------------------------------------------------------------------------
            | Variants — one independent combination set per type
            |--------------------------------------------------------------------------
            */

            foreach (self::VARIANT_TYPES as $type) {
                $this->createVariantsForType($request, $product, $type);
            }

            /*
            |--------------------------------------------------------------------------
            | Collections
            |--------------------------------------------------------------------------
            */

            if ($request->filled('collections')) {
                $product->collections()->sync($request->collections);
            }

            DB::commit();

            return redirect()
                ->route('admin.products.index')
                ->with('success', 'Product created successfully.');

        } catch (\Throwable $e) {

            DB::rollBack();

            Log::error('Product store failed', [
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
            ]);

            return back()
                ->withInput()
                ->withErrors(['error' => $e->getMessage()]);
        }
    }

    public function edit(Product $product)
    {
        $product->load([

            'images',
            'videos',
            'addons',
            'includedItems',
            'benefits',
            'highlights',
            'collections',

            'attributeValues.attribute',
            'attributeValues.value',

            'variants.values.attributeValue',
            'variants.images',

        ]);

        $categories = Category::whereNull('parent_id')
            ->where('status', 1)
            ->orderBy('name')
            ->get();

        $subcategories = Category::where('parent_id', $product->category_id)
            ->where('status', 1)
            ->orderBy('name')
            ->get();

        $selectedAttributeValues = $product
            ->attributeValues
            ->pluck('attribute_value_id')
            ->toArray();

        // ✅ Existing variants grouped by type, so the edit form can
        // rebuild each of the (up to) 4 independent tables separately.
        $existingVariantsByType = [];

        foreach (self::VARIANT_TYPES as $type) {

            $existingVariantsByType[$type] = $product->variants
                ->where('type', $type)
                ->map(function ($variant) {

                    return [

                        'id' => $variant->id,
                        'sku' => $variant->sku,
                        'mrp' => $variant->mrp,
                        'discount_type' => $variant->discount_type,
                        'discount' => $variant->discount,
                        'price' => $variant->price,
                        'stock' => $variant->stock,
                        'image' => $variant->image,

                        // so the edit form can pre-check "Not offered" and grey out the row
                        'is_available' => (bool) $variant->is_available,

                        'images' => $variant->images->map(function ($img) {
                            return [
                                'id' => $img->id,
                                'image' => $img->image,
                                'thumb' => $img->thumb,
                                'is_default' => $img->is_default,
                            ];
                        })->values(),

                        'variant_name' => $variant->values
                            ->map(function ($v) {
                                return $v->attributeValue->value;
                            })
                            ->implode(' / '),

                        'attribute_value_ids' => $variant->values
                            ->pluck('attribute_value_id')
                            ->toArray(),

                    ];

                })
                ->values();
        }

        $collections = Collection::where('status', 1)
            ->orderBy('sort_order')
            ->get();

        return view(
            'admin.products.edit',
            compact(
                'product',
                'categories',
                'subcategories',
                'selectedAttributeValues',
                'existingVariantsByType',
                'collections'
            )
        );
    }

    public function update(Request $request, Product $product)
    {
        $this->validateProduct($request);

        DB::beginTransaction();

        try {

            $product->update(
                $this->productData($request) + [
                    'slug' => $this->resolveSlugOnUpdate($product, $request->slug, $request->name),
                ]
            );

            // ✅ ADD NEW IMAGES (old ones are kept — safe approach)
            $defaultType = $request->default_type;

            // RESET ALL DEFAULTS
            $product->images()->update(['is_default' => 0]);

            // ✅ EXISTING DEFAULT
            if ($defaultType && str_starts_with($defaultType, 'old_')) {

                $id = str_replace('old_', '', $defaultType);

                ProductImage::where('id', $id)
                    ->where('product_id', $product->id)
                    ->update(['is_default' => 1]);
            }

            if ($request->hasFile('images')) {
                foreach ($request->file('images') as $index => $img) {

                    $paths = $this->compressAndStore(
                        $img,
                        'products'
                    );

                    ProductImage::create([
                        'product_id' => $product->id,
                        'image' => $paths['full'],
                        'thumb' => $paths['thumb'],
                        'is_default' => $defaultType === 'new_' . $index ? 1 : 0,
                    ]);
                }
            }

            // DELETE SELECTED IMAGES (scoped to this product)
            foreach ($request->input('delete_images', []) as $imgId) {

                $img = $product->images()->find($imgId);

                if ($img) {
                    if (Storage::disk('public')->exists($img->image)) {
                        Storage::disk('public')->delete($img->image);
                    }
                    if ($img->thumb && Storage::disk('public')->exists($img->thumb)) {
                        Storage::disk('public')->delete($img->thumb);
                    }
                    $img->delete();
                }
            }

            // If the default was deleted / never chosen, fall back to the first image.
            $this->ensureDefaultImage($product);

            /*
            |--------------------------------------------------------------------------
            | Product Videos (ADD NEW, KEEP OLD — same safe approach as images)
            |--------------------------------------------------------------------------
            */

            if ($request->hasFile('videos')) {
                foreach ($request->file('videos') as $video) {

                    $path = $video->store('product-videos', 'public');

                    ProductVideo::create([
                        'product_id' => $product->id,
                        'video' => $path,
                    ]);
                }
            }

            // DELETE SELECTED VIDEOS (scoped to this product)
            foreach ($request->input('delete_videos', []) as $videoId) {

                $vid = $product->videos()->find($videoId);

                if ($vid) {
                    if (Storage::disk('public')->exists($vid->video)) {
                        Storage::disk('public')->delete($vid->video);
                    }
                    $vid->delete();
                }
            }

            /*
            |--------------------------------------------------------------------------
            | Delete individually-removed variant images (scoped to this product)
            |--------------------------------------------------------------------------
            */

            if ($request->filled('delete_variant_images')) {

                $ownVariantIds = $product->variants()->pluck('id');

                foreach ($request->delete_variant_images as $imgId) {

                    $img = ProductVariantImage::whereIn('variant_id', $ownVariantIds)->find($imgId);

                    if ($img) {
                        if (Storage::disk('public')->exists($img->image)) {
                            Storage::disk('public')->delete($img->image);
                        }
                        if ($img->thumb && Storage::disk('public')->exists($img->thumb)) {
                            Storage::disk('public')->delete($img->thumb);
                        }
                        $img->delete();
                    }
                }
            }

            /*
            |--------------------------------------------------------------------------
            | Addon Options (SYNC — replace the full set each save)
            |--------------------------------------------------------------------------
            */

            $product->addons()->delete();

            foreach ($request->input('addons', []) as $addon) {

                if (empty($addon['detail'])) {
                    continue;
                }

                ProductAddon::create([
                    'product_id' => $product->id,
                    'detail' => $addon['detail'],
                    'price' => ($addon['price'] ?? '') !== '' ? $addon['price'] : 0,
                ]);
            }

            /*
            |--------------------------------------------------------------------------
            | What's In The Box / Developmental Benefits / Overview Highlights (SYNC)
            |--------------------------------------------------------------------------
            */

            $this->syncContentRows($request, $product);

            /*
            |--------------------------------------------------------------------------
            | Product Attributes (SYNC)
            |--------------------------------------------------------------------------
            */

            $currentAttributes = ProductAttributeValue::where(
                'product_id',
                $product->id
            )->get();

            $newKeys = [];

            foreach ($request->attribute_values ?? [] as $attributeId => $values) {

                foreach ($values as $valueId) {

                    $newKeys[] = $attributeId . '-' . $valueId;

                    ProductAttributeValue::firstOrCreate([
                        'product_id' => $product->id,
                        'attribute_id' => $attributeId,
                        'attribute_value_id' => $valueId,
                    ]);
                }
            }

            foreach ($currentAttributes as $row) {

                $key = $row->attribute_id . '-' . $row->attribute_value_id;

                if (!in_array($key, $newKeys)) {
                    $row->delete();
                }
            }

            /*
            |--------------------------------------------------------------------------
            | Variants — sync each type independently
            |--------------------------------------------------------------------------
            */

            foreach (self::VARIANT_TYPES as $type) {
                $this->syncVariantsForType($request, $product, $type);
            }

            /*
            |--------------------------------------------------------------------------
            | Collections
            |--------------------------------------------------------------------------
            */

            $product->collections()->sync($request->collections ?? []);

            DB::commit();

            return redirect()
                ->route('admin.products.index')
                ->with('success', 'Product updated successfully.');

        } catch (\Throwable $e) {

            DB::rollBack();

            Log::error('Product update failed', [
                'product_id' => $product->id,
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
            ]);

            return back()
                ->withInput()
                ->withErrors(['error' => $e->getMessage()]);
        }
    }

    public function destroy($id)
    {
        $product = Product::findOrFail($id);

        $product->delete();

        return response()->json([
            'message' => 'Product Deleted Successfully'
        ]);
    }

    /**
     * Guarantees that a product with images always has exactly one default.
     */
    private function ensureDefaultImage(Product $product): void
    {
        $images = $product->images()->get();

        if ($images->isEmpty() || $images->contains('is_default', 1)) {
            return;
        }

        $images->first()->update(['is_default' => 1]);
    }

    /*
    |--------------------------------------------------------------------------
    | Variant helpers (type-aware)
    |--------------------------------------------------------------------------
    | The request carries up to 4 arrays: variants_price, variants_image,
    | variants_stock, variants_sku — each a plain (non-associative) list of
    | combinations belonging ONLY to that dependency type. Every combination
    | entry looks like:
    |   [ 'id' => (existing variant id, edit only), 'values' => [attrValueId, ...], ...type-specific fields ]
    */

    protected function inputKeyForType(string $type): string
    {
        return 'variants_' . $type;
    }

    protected function fillVariantFieldsForType(ProductVariant $variant, string $type, array $data, Request $request, int $index): void
    {
        // ✅ applies to every type — checked "Not offered" in the form means
        // is_available = false; unchecked (or absent) means true.
        $variant->is_available = !isset($data['excluded']);

        switch ($type) {

            case ProductVariant::TYPE_PRICE:
                $variant->fill([
                    'mrp' => $data['mrp'] ?? 0,
                    'discount_type' => $data['discount_type'] ?? 'amount',
                    'discount' => $data['discount'] ?? 0,
                    'price' => $data['price'] ?? 0,
                ]);
                break;

            case ProductVariant::TYPE_STOCK:
                $variant->fill([
                    'stock' => $data['stock'] ?? 0,
                ]);
                break;

            case ProductVariant::TYPE_SKU:
                $variant->fill([
                    'sku' => $data['sku'] ?? null,
                ]);
                break;

            case ProductVariant::TYPE_IMAGE:
                // Multiple images per variant are handled AFTER save() in
                // createVariantsForType() / syncVariantsForType(), since
                // ProductVariantImage rows need a real variant_id to attach to.
                break;
        }
    }

    /**
     * Stores newly-uploaded images for an image-type variant. Existing
     * ProductVariantImage rows are left untouched unless the admin
     * explicitly marks one for deletion via delete_variant_images[].
     */
    protected function storeVariantImages(Request $request, ProductVariant $variant, int $index): void
    {
        $files = $request->file("variants_image.$index.images") ?? [];

        if (!is_array($files)) {
            $files = [$files];
        }

        $hasExisting = $variant->images()->exists();

        foreach ($files as $i => $file) {

            if (!$file instanceof UploadedFile) {
                continue;
            }

            $paths = $this->compressAndStore(
                $file,
                'product-variants'
            );

            ProductVariantImage::create([
                'variant_id' => $variant->id,
                'image' => $paths['full'],
                'thumb' => $paths['thumb'],
                // First image becomes default only if this variant had none before.
                'is_default' => (!$hasExisting && $i === 0) ? 1 : 0,
            ]);
        }

        // Keep the legacy single `image` column in sync as "the default
        // image for this variant".
        $default = $variant->images()->where('is_default', 1)->first()
            ?? $variant->images()->first();

        if ($default) {
            $variant->image = $default->image;
            $variant->save();
        }
    }

    /**
     * Create-only path (used by store()) — no existing rows to reconcile.
     */
    protected function createVariantsForType(Request $request, Product $product, string $type): void
    {
        $inputKey = $this->inputKeyForType($type);

        if (!$request->filled($inputKey)) {
            return;
        }

        foreach ($request->$inputKey as $index => $data) {

            $variant = new ProductVariant();
            $variant->product_id = $product->id;
            $variant->type = $type;

            $this->fillVariantFieldsForType($variant, $type, $data, $request, $index);

            $variant->save();

            foreach ($data['values'] ?? [] as $valueId) {
                ProductVariantValue::create([
                    'variant_id' => $variant->id,
                    'attribute_value_id' => $valueId,
                ]);
            }

            if ($type === ProductVariant::TYPE_IMAGE) {
                $this->storeVariantImages($request, $variant, $index);
            }
        }
    }

    /**
     * Create/update/delete path (used by update()) — reconciles submitted
     * combinations for this type against what already exists in the DB,
     * scoped to this type only so other types are left untouched.
     */
    protected function syncVariantsForType(Request $request, Product $product, string $type): void
    {
        $inputKey = $this->inputKeyForType($type);

        $existingIds = [];

        foreach ($request->$inputKey ?? [] as $index => $data) {

            if (!empty($data['id'])) {

                $variant = ProductVariant::where('product_id', $product->id)
                    ->where('type', $type)
                    ->where('id', $data['id'])
                    ->first();

                if (!$variant) {
                    continue;
                }

                $existingIds[] = $variant->id;

            } else {

                $variant = new ProductVariant();
                $variant->product_id = $product->id;
                $variant->type = $type;
            }

            $this->fillVariantFieldsForType($variant, $type, $data, $request, $index);

            $variant->save();

            if ($type === ProductVariant::TYPE_IMAGE) {
                $this->storeVariantImages($request, $variant, $index);
            }

            if (empty($data['id'])) {
                $existingIds[] = $variant->id;
            }

            // Re-sync value pivots (new rows, or regenerated combinations).
            ProductVariantValue::where('variant_id', $variant->id)->delete();

            foreach ($data['values'] ?? [] as $valueId) {
                ProductVariantValue::create([
                    'variant_id' => $variant->id,
                    'attribute_value_id' => $valueId,
                ]);
            }
        }

        // Delete variants of this type that were removed on the form.
        $toDelete = ProductVariant::where('product_id', $product->id)
            ->where('type', $type);

        if (!empty($existingIds)) {
            $toDelete->whereNotIn('id', $existingIds);
        }

        $toDelete = $toDelete->get();

        foreach ($toDelete as $variant) {

            if ($variant->image) {
                Storage::disk('public')->delete($variant->image);
            }

            // ✅ delete all of this variant's images too
            foreach ($variant->images as $img) {
                if (Storage::disk('public')->exists($img->image)) {
                    Storage::disk('public')->delete($img->image);
                }
                if ($img->thumb && Storage::disk('public')->exists($img->thumb)) {
                    Storage::disk('public')->delete($img->thumb);
                }
                $img->delete();
            }

            ProductVariantValue::where('variant_id', $variant->id)->delete();

            $variant->delete();
        }
    }

    private function generateUniqueSlug(string $name, ?int $ignoreId = null): string
    {
        $slug = Str::slug($name);
        $originalSlug = $slug;

        $count = 1;

        while (
            Product::where('slug', $slug)
                ->when($ignoreId, function ($q) use ($ignoreId) {
                    $q->where('id', '!=', $ignoreId);
                })
                ->exists()
        ) {
            $slug = $originalSlug . '-' . $count;
            $count++;
        }

        return $slug;
    }

    private function resolveSlugOnUpdate(Product $product, ?string $requestedSlug, string $name): string
    {
        $source = $requestedSlug ?: $name;
        $candidateSlug = Str::slug($source);

        // If the slug would be the same as what's already saved, don't touch it.
        if ($candidateSlug === $product->slug) {
            return $product->slug;
        }

        // Only regenerate + check uniqueness if it actually changed.
        return $this->generateUniqueSlug($source, $product->id);
    }

    public function suggestionKeywords(Request $request)
    {
        $query = trim($request->get('q', ''));

        if ($query === '') {
            return response()->json([]);
        }

        $keywords = \App\Models\ProductKeyword::where('keyword', 'like', "%{$query}%")
            ->distinct()
            ->orderBy('keyword')
            ->limit(15)
            ->pluck('keyword');

        return response()->json($keywords);
    }

}