<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AgeGroup;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class AgeGroupController extends Controller
{
    public function index()
    {
        $groups = AgeGroup::ordered()->get();

        // visible-product count per group (overlap rule)
        $groups->each(function ($g) {
            $g->products_total = $g->applyToProducts(Product::where('status', 1))->count();
        });

        return view('admin.home.age-groups', [
            'groups' => $groups,
            'colors' => AgeGroup::COLORS,
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'age_min'     => 'required|integer|min:0|max:18',
            'age_max'     => 'nullable|integer|min:0|max:18|gte:age_min',
            'name'        => 'required|string|max:80',
            'label'       => 'nullable|string|max:60',
            'description' => 'nullable|string|max:160',
            'icon'        => 'nullable|string|max:60',
            'color'       => ['required', Rule::in(AgeGroup::COLORS)],
            'sort_order'  => 'nullable|integer|min:0',
        ]);

        $min = (int) $data['age_min'];
        $max = isset($data['age_max']) ? (int) $data['age_max'] : null;

        // same range = same slug, so block duplicates
        if (AgeGroup::where('slug', AgeGroup::makeSlug($min, $max))->exists()) {
            return back()->withInput()->withErrors(['age_min' => 'An age group with this range already exists.']);
        }

        $data['age_max']    = $max;
        $data['sort_order'] = $data['sort_order'] ?? 0;
        $data['status']     = $request->boolean('status');

        AgeGroup::create($data);

        return redirect()->route('admin.home.age-groups.index')->with('success', 'Age group added.');
    }

    public function update(Request $request, AgeGroup $age_group)
    {
        // Range (and therefore the URL key) is locked after creation
        $data = $request->validate([
            'name'        => 'required|string|max:80',
            'label'       => 'nullable|string|max:60',
            'description' => 'nullable|string|max:160',
            'icon'        => 'nullable|string|max:60',
            'color'       => ['required', Rule::in(AgeGroup::COLORS)],
            'sort_order'  => 'nullable|integer|min:0',
        ]);

        $data['sort_order'] = $data['sort_order'] ?? 0;
        $data['status']     = $request->boolean('status');

        $age_group->update($data);

        return redirect()->route('admin.home.age-groups.index')->with('success', 'Age group updated.');
    }

    public function destroy(AgeGroup $age_group)
    {
        // Products are matched by their own age_min/age_max, so nothing else is affected
        $age_group->delete();

        return response()->json(['message' => 'Age group deleted.']);
    }
}