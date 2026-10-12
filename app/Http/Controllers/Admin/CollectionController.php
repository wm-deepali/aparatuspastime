<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CollectionController extends Controller
{
    public function index(Request $request)
    {
        $query = Collection::query();

        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        // The status filter existed in the view but was never applied
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $collections = $query
            ->orderBy('sort_order')
            ->paginate(10)
            ->withQueryString();

        return view('admin.collections.index', compact('collections'));
    }

    public function create()
    {
        return view('admin.collections.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|max:255',
            'meta_title' => 'nullable|max:255',
            'meta_description' => 'nullable',
        ] + $this->headerRules());

        $slug = $request->slug
            ? Str::slug($request->slug)
            : Str::slug($request->name);

        Collection::create([
            'name' => $request->name,
            'slug' => $slug,
            'code' => $slug,
            'status' => $request->status ?? 1,
            'sort_order' => $request->sort_order ?? 0,
            'meta_title' => $request->meta_title,
            'meta_description' => $request->meta_description,
            // is_system is never set from a request, only by the seeder/migration
        ] + $this->headerData($request));

        return redirect()
            ->route('admin.collections.index')
            ->with('success', 'Collection created successfully.');
    }

    public function edit($id)
    {
        $collection = Collection::findOrFail($id);

        return view('admin.collections.edit', compact('collection'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|max:255',
            'meta_title' => 'nullable|max:255',
            'meta_description' => 'nullable',
        ] + $this->headerRules());

        $collection = Collection::findOrFail($id);

        $data = [
            'name' => $request->name,
            'status' => $request->status ?? 1,
            'sort_order' => $request->sort_order ?? 0,
            'meta_title' => $request->meta_title,
            'meta_description' => $request->meta_description,
        ] + $this->headerData($request);

        // System collections keep their code/slug: the storefront looks them up by code
        if (!$collection->is_system) {
            $slug = $request->slug
                ? Str::slug($request->slug)
                : Str::slug($request->name);

            $data['slug'] = $slug;
            $data['code'] = $slug;
        }

        $collection->update($data);

        return redirect()
            ->route('admin.collections.index')
            ->with('success', 'Collection updated successfully.');
    }

    public function destroy($id)
    {
        $collection = Collection::findOrFail($id);

        if ($collection->is_system) {
            return response()->json([
                'message' => 'This is a system collection and cannot be deleted.'
            ], 403);
        }

        $collection->delete();

        return response()->json([
            'message' => 'Collection deleted successfully.'
        ]);
    }

    /**
     * Validation rules for the header navigation fields.
     */
    private function headerRules(): array
    {
        return [
            'show_in_header' => 'nullable|boolean',
            'header_order'   => 'nullable|integer|min:0',
            'header_icon'    => 'nullable|string|max:100',
            'header_color'   => 'nullable|string|max:50',
            'header_badge'   => 'nullable|string|max:20',
        ];
    }

    /**
     * Header navigation data shared by store() and update().
     */
    private function headerData(Request $request): array
    {
        return [
            'show_in_header' => $request->boolean('show_in_header'),
            'header_order'   => $request->header_order ?? 0,
            'header_icon'    => $request->header_icon,
            'header_color'   => $request->header_color,
            'header_badge'   => $request->header_badge,
        ];
    }
}