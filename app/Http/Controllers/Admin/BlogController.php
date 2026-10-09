<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class BlogController extends Controller
{
    private const IMAGE_FIELDS = ['image', 'banner_image', 'author_avatar'];

    public function index()
    {
        $blogs = Blog::latest('id')->paginate(15);

        return view('admin.blogs.index', compact('blogs'));
    }

    public function create()
    {
        return view('admin.blogs.create', $this->formData());
    }

    public function store(Request $request)
    {
        $data = $this->validated($request);
        $data = $this->payload($request, $data);

        $blog = Blog::create($data);
        $this->singleFeatured($blog);

        return redirect()->route('admin.blogs.index')->with('success', 'Blog created successfully.');
    }

    public function edit($id)
    {
        $blog = Blog::findOrFail($id);

        return view('admin.blogs.edit', $this->formData() + compact('blog'));
    }

    public function update(Request $request, $id)
    {
        $blog = Blog::findOrFail($id);

        $data = $this->validated($request, $blog->id);
        $data = $this->payload($request, $data, $blog);

        $blog->update($data);
        $this->singleFeatured($blog);

        return redirect()->route('admin.blogs.index')->with('success', 'Blog updated successfully.');
    }

    public function destroy($id)
    {
        $blog = Blog::findOrFail($id);

        foreach (self::IMAGE_FIELDS as $f) {
            $this->deleteFile($blog->{$f});
        }

        $blog->delete();

        return response()->json(['message' => 'Blog deleted successfully.']);
    }

    /* ───────── helpers ───────── */

    private function formData(): array
    {
        return [
            'categories' => Blog::whereNotNull('category')->distinct()->orderBy('category')->pluck('category'),
            'products' => Product::orderBy('name')->get(['id', 'name']),
        ];
    }

    private function validated(Request $request, ?int $ignoreId = null): array
    {
        return $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:blogs,slug' . ($ignoreId ? ',' . $ignoreId : ''),
            'category' => 'nullable|string|max:100',
            'short_description' => 'nullable|string',
            'content' => 'required|string',
            'image' => 'nullable|image|max:4096',
            'banner_image' => 'nullable|image|max:6144',
            'author_name' => 'nullable|string|max:150',
            'author_role' => 'nullable|string|max:200',
            'author_bio' => 'nullable|string',
            'author_avatar' => 'nullable|image|max:2048',
            'key_takeaways' => 'nullable|string',
            'tags' => 'nullable|string',
            'recommended_product_ids' => 'nullable|array',
            'recommended_product_ids.*' => 'integer',
            'read_time' => 'nullable|integer|min:1|max:999',
            'published_at' => 'nullable|date',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string',
        ]);
    }

    private function payload(Request $request, array $data, ?Blog $blog = null): array
    {
        $data['slug'] = Str::slug($data['slug'] ?: $data['title']);
        $data['category_slug'] = filled($data['category'] ?? null) ? Str::slug($data['category']) : null;

        // One takeaway per line
        $data['key_takeaways'] = collect(preg_split('/\R/', (string) ($data['key_takeaways'] ?? '')))
            ->map(fn($l) => trim($l))->filter()->values()->all() ?: null;

        // Comma separated tags (leading # allowed)
        $data['tags'] = collect(explode(',', (string) ($data['tags'] ?? '')))
            ->map(fn($t) => trim(ltrim(trim($t), '#')))->filter()->unique()->values()->all() ?: null;

        $data['recommended_product_ids'] = collect($data['recommended_product_ids'] ?? [])
            ->map(fn($i) => (int) $i)->unique()->values()->all() ?: null;

        $data['published_at'] = $data['published_at'] ?? null;

        // Checkboxes
        $data['status'] = $request->has('status') ? 1 : 0;
        $data['show_home'] = $request->has('show_home') ? 1 : 0;
        $data['is_featured'] = $request->has('is_featured') ? 1 : 0;

        // Images: keep the old file unless a new one is uploaded
        foreach (self::IMAGE_FIELDS as $f) {
            unset($data[$f]);

            if ($request->hasFile($f)) {
                if ($blog) {
                    $this->deleteFile($blog->{$f});
                }
                $data[$f] = $request->file($f)->store('blogs', 'public');
            }
        }

        return $data;
    }

    private function singleFeatured(Blog $blog): void
    {
        if ($blog->is_featured) {
            Blog::where('id', '!=', $blog->id)->update(['is_featured' => 0]);
        }
    }

    // Only delete files we stored ourselves (not URLs or assets/ paths)
    private function deleteFile(?string $path): void
    {
        if (filled($path) && !Str::startsWith($path, ['http://', 'https://', 'assets/', 'images/'])) {
            Storage::disk('public')->delete($path);
        }
    }
}