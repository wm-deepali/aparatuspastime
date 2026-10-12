<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Faq;
use App\Models\FaqCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class FaqController extends Controller
{
    public function index()
    {
        $categories = FaqCategory::withCount('faqs')->orderBy('sort_order')->orderBy('id')->get();

        $faqs = Faq::with('category')
            ->orderBy('faq_category_id')
            ->orderBy('sort_order')
            ->orderBy('id')
            ->get();

        return view('admin.faqs.index', compact('categories', 'faqs'));
    }

    /* ───────── Categories ───────── */

    public function storeCategory(Request $request)
    {
        FaqCategory::create($this->categoryData($request));

        return back()->with('success', 'Category added.');
    }

    public function updateCategory(Request $request, $id)
    {
        FaqCategory::findOrFail($id)->update($this->categoryData($request, $id));

        return back()->with('success', 'Category updated.');
    }

    public function destroyCategory($id)
    {
        // Questions inside are deleted too (cascade)
        FaqCategory::findOrFail($id)->delete();

        return response()->json(['message' => 'Category and its questions deleted.']);
    }

    /* ───────── Questions ───────── */

    public function storeFaq(Request $request)
    {
        Faq::create($this->faqData($request));

        return back()->with('success', 'Question added.');
    }

    public function updateFaq(Request $request, $id)
    {
        Faq::findOrFail($id)->update($this->faqData($request));

        return back()->with('success', 'Question updated.');
    }

    public function destroyFaq($id)
    {
        Faq::findOrFail($id)->delete();

        return response()->json(['message' => 'Question deleted.']);
    }

    /* ───────── helpers ───────── */

    private function categoryData(Request $request, $ignoreId = null): array
    {
        $v = $request->validate([
            'name' => 'required|string|max:150',
            'icon' => 'nullable|string|max:60',
            'color' => 'required|in:blue,orange,purple,rose,mint,yellow',
            'sort_order' => 'nullable|integer|min:0',
        ]);

        $slug = Str::slug($v['name']);
        $base = $slug ?: 'category';
        $i = 2;
        while (FaqCategory::where('slug', $slug)->when($ignoreId, fn($q) => $q->where('id', '!=', $ignoreId))->exists()) {
            $slug = $base . '-' . $i++;
        }

        return [
            'name' => $v['name'],
            'slug' => $slug,
            'icon' => $v['icon'] ?: null,
            'color' => $v['color'],
            'sort_order' => $v['sort_order'] ?? 0,
            'status' => $request->has('status') ? 1 : 0,
        ];
    }

    private function faqData(Request $request): array
    {
        $v = $request->validate([
            'faq_category_id' => 'required|exists:faq_categories,id',
            'question' => 'required|string|max:255',
            'answer' => 'required|string',
            'sort_order' => 'nullable|integer|min:0',
        ]);

        return [
            'faq_category_id' => $v['faq_category_id'],
            'question' => $v['question'],
            'answer' => $v['answer'],
            'sort_order' => $v['sort_order'] ?? 0,
            'status' => $request->has('status') ? 1 : 0,
        ];
    }
}