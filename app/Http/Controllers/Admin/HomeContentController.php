<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class HomeContentController extends Controller
{
    public function index(string $type)
    {
        $cfg   = $this->cfg($type);
        $items = $cfg['model']::query()->ordered()->paginate(15);

        return view('admin.home.content.index', compact('type', 'cfg', 'items'));
    }

    public function create(string $type)
    {
        $cfg = $this->cfg($type);

        return view('admin.home.content.form', [
            'type'       => $type,
            'cfg'        => $cfg,
            'item'       => new $cfg['model'],
            'categories' => $this->categories($cfg),
        ]);
    }

    public function store(Request $request, string $type)
    {
        $cfg = $this->cfg($type);

        $request->validate($this->rules($cfg, true));
        $cfg['model']::create($this->payload($request, $cfg));

        return redirect()
            ->route('admin.home.content.index', $type)
            ->with('success', $cfg['singular'] . ' added successfully.');
    }

    public function edit(string $type, $id)
    {
        $cfg = $this->cfg($type);

        return view('admin.home.content.form', [
            'type'       => $type,
            'cfg'        => $cfg,
            'item'       => $cfg['model']::findOrFail($id),
            'categories' => $this->categories($cfg),
        ]);
    }

    public function update(Request $request, string $type, $id)
    {
        $cfg  = $this->cfg($type);
        $item = $cfg['model']::findOrFail($id);

        $request->validate($this->rules($cfg, false));
        $item->update($this->payload($request, $cfg, $item));

        return redirect()
            ->route('admin.home.content.index', $type)
            ->with('success', $cfg['singular'] . ' updated successfully.');
    }

    public function destroy(string $type, $id)
    {
        $cfg  = $this->cfg($type);
        $item = $cfg['model']::findOrFail($id);

        foreach ($cfg['fields'] as $f) {
            if ($f['type'] === 'image' && $item->{$f['name']}) {
                Storage::disk('public')->delete($item->{$f['name']});
            }
        }

        $item->delete();

        return response()->json(['message' => $cfg['singular'] . ' deleted successfully.']);
    }

    /* ------------------------------------------------------------------ */

    protected function cfg(string $type): array
    {
        $cfg = config("home_content.types.$type");
        abort_unless($cfg, 404);

        return $cfg;
    }

    protected function categories(array $cfg)
    {
        return collect($cfg['fields'])->contains('type', 'category')
            ? Category::active()->ordered()->get(['id', 'name'])
            : collect();
    }

    protected function options(array $field): array
    {
        return is_array($field['options'])
            ? $field['options']
            : config('home_content.' . $field['options'], []);
    }

    protected function rules(array $cfg, bool $creating): array
    {
        $rules = [
            'sort_order' => 'nullable|integer|min:0',
            'status'     => 'nullable|in:0,1',
        ];

        foreach ($cfg['fields'] as $f) {
            $r = $f['rules'] ?? 'nullable';

            switch ($f['type']) {
                case 'image':
                    $r = (($creating && !empty($f['required'])) ? 'required' : 'nullable')
                        . '|image|mimes:jpg,jpeg,png,webp|max:4096';
                    break;
                case 'select':
                    $r .= '|in:' . implode(',', array_keys($this->options($f)));
                    break;
                case 'category':
                    $r = 'nullable|exists:categories,id';
                    break;
                case 'switch':
                    $r = 'nullable|in:0,1';
                    break;
            }

            $rules[$f['name']] = $r;
        }

        return $rules;
    }

    protected function payload(Request $request, array $cfg, ?Model $item = null): array
    {
        $data = [
            'sort_order' => (int) $request->input('sort_order', 0),
            'status'     => $request->boolean('status', true),
        ];

        foreach ($cfg['fields'] as $f) {
            $name = $f['name'];

            if ($f['type'] === 'image') {
                if ($request->hasFile($name)) {
                    if ($item && $item->{$name}) {
                        Storage::disk('public')->delete($item->{$name});
                    }
                    $data[$name] = $request->file($name)->store($cfg['image_dir'], 'public');
                }
                continue;
            }

            $data[$name] = $f['type'] === 'switch'
                ? $request->boolean($name)
                : $request->input($name);
        }

        return $data;
    }
}