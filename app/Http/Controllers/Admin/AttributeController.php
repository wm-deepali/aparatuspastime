<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Attribute;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AttributeController extends Controller
{
    private const TYPES = ['button', 'dropdown', 'image', 'color_swatch', 'radio'];

    private function rules(): array
    {
        return [
            'name'           => 'required|max:255',
            'type'           => 'required|in:' . implode(',', self::TYPES),
            'icon'           => ['nullable', 'string', 'max:100', 'regex:/^[a-z0-9\- ]+$/i'],
            'has_values'     => 'required|boolean',
            'status'         => 'required|boolean',
            'show_in_navbar' => 'required|boolean',
        ];
    }

    private function payload(Request $request): array
    {
        return [
            'name'           => $request->name,
            'slug'           => Str::slug($request->name),
            'type'           => $request->type,
            'icon'           => trim((string) $request->icon) ?: null,
            'has_values'     => $request->has_values,
            'status'         => $request->status,
            'show_in_navbar' => $request->show_in_navbar,
        ];
    }

    public function index()
    {
        $attributes = Attribute::latest()->paginate(20);

        return view('admin.attributes.index', compact('attributes'));
    }

    public function create()
    {
        $types = self::TYPES;

        return view('admin.attributes.create', compact('types'));
    }

    public function store(Request $request)
    {
        $request->validate($this->rules());

        Attribute::create($this->payload($request));

        return redirect()
            ->route('admin.attributes.index')
            ->with('success', 'Attribute created successfully.');
    }

    public function edit(Attribute $attribute)
    {
        $types = self::TYPES;

        return view('admin.attributes.edit', compact('attribute', 'types'));
    }

    public function update(Request $request, Attribute $attribute)
    {
        $request->validate($this->rules());

        $attribute->update($this->payload($request));

        return redirect()
            ->route('admin.attributes.index')
            ->with('success', 'Attribute updated successfully.');
    }

    public function destroy(Attribute $attribute)
    {
        $attribute->delete();

        return redirect()
            ->route('admin.attributes.index')
            ->with('success', 'Attribute deleted successfully.');
    }
}