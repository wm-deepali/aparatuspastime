<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DynamicPage;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class DynamicPageController extends Controller
{
    public function index()
    {
        $pages = DynamicPage::orderByDesc('is_system')->orderBy('heading')->get();

        return view('admin.dynamic-pages.index', compact('pages'));
    }

    public function create()
    {
        $page = new DynamicPage([
            'date_label'     => 'Last Updated',
            'effective_date' => now(),
            'status'         => true,
        ]);

        return view('admin.dynamic-pages.form', compact('page'));
    }

    public function store(Request $request)
    {
        $data = $this->validated($request);

        // slug: typed value, else made from the heading
        $slug = Str::slug($request->input('slug') ?: $data['heading']);

        if ($slug === '' || DynamicPage::where('slug', $slug)->exists()) {
            return back()->withInput()->withErrors(['slug' => 'This URL key is empty or already used. Try another one.']);
        }

        $data['slug']      = $slug;
        $data['is_system'] = false;

        DynamicPage::create($data);

        return redirect()->route('admin.dynamic-pages.index')->with('success', 'Page created.');
    }

    public function edit(DynamicPage $dynamic_page)
    {
        return view('admin.dynamic-pages.form', ['page' => $dynamic_page]);
    }

    public function update(Request $request, DynamicPage $dynamic_page)
    {
        $data = $this->validated($request);

        // System pages keep their slug (the footer links to them by route name)
        if (!$dynamic_page->is_system) {
            $slug = Str::slug($request->input('slug') ?: $data['heading']);

            $taken = DynamicPage::where('slug', $slug)->where('id', '!=', $dynamic_page->id)->exists();
            if ($slug === '' || $taken) {
                return back()->withInput()->withErrors(['slug' => 'This URL key is empty or already used. Try another one.']);
            }

            $data['slug'] = $slug;
        }

        $dynamic_page->update($data);

        return redirect()->route('admin.dynamic-pages.index')->with('success', 'Page updated.');
    }

    public function destroy(DynamicPage $dynamic_page)
    {
        if ($dynamic_page->is_system) {
            return response()->json(['message' => 'Built-in pages cannot be deleted. Hide the page instead.'], 403);
        }

        $dynamic_page->delete();

        return response()->json(['message' => 'Page deleted.']);
    }

    /* ---------- helpers ---------- */

    private function validated(Request $request): array
    {
        $data = $request->validate([
            'heading'          => 'required|string|max:255',
            'badge_text'       => 'nullable|string|max:60',
            'date_label'       => ['required', Rule::in(DynamicPage::DATE_LABELS)],
            'effective_date'   => 'nullable|date',
            'content'          => 'required|string',
            'meta_title'       => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:500',
        ]);

        // Admin-authored HTML is shown unescaped, so drop script tags and inline handlers as a safety net
        $data['content'] = preg_replace('#<script\b[^>]*>.*?</script>#is', '', $data['content']);
        $data['content'] = preg_replace('/\son\w+\s*=\s*("[^"]*"|\'[^\']*\')/i', '', $data['content']);

        $data['status'] = $request->boolean('status');

        return $data;
    }
}