<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\HomeSection;
use Illuminate\Http\Request;

class HomeSectionController extends Controller
{
    public function index()
    {
        $sections = config('home_content.sections');
        $rows     = HomeSection::all()->keyBy('section_key');

        return view('admin.home.sections.index', compact('sections', 'rows'));
    }

    public function edit(string $key)
    {
        $cfg     = $this->cfg($key);
        $section = $this->row($key, $cfg);

        return view('admin.home.sections.edit', compact('key', 'cfg', 'section'));
    }

    public function update(Request $request, string $key)
    {
        $cfg     = $this->cfg($key);
        $section = $this->row($key, $cfg);

        $rules = ['status' => 'nullable|in:0,1'];
        foreach ($cfg['fields'] as $f) {
            $rules[$f] = config("home_content.section_fields.$f.rules");
        }
        $request->validate($rules);

        $data  = [];
        $extra = $section->extra ?? [];

        foreach ($cfg['fields'] as $f) {
            if (str_starts_with($f, 'extra_')) {
                $extra[substr($f, 6)] = $request->input($f);
            } else {
                $data[$f] = $request->input($f);
            }
        }

        $data['extra']  = $extra ?: null;
        $data['status'] = $request->boolean('status', true);

        $section->update($data);

        return redirect()
            ->route('admin.home.sections.index')
            ->with('success', $cfg['title'] . ' updated successfully.');
    }

    protected function cfg(string $key): array
    {
        $cfg = config("home_content.sections.$key");
        abort_unless($cfg, 404);

        return $cfg;
    }

    // First open creates the row pre-filled with the current default text
    protected function row(string $key, array $cfg): HomeSection
    {
        return HomeSection::firstOrCreate(
            ['section_key' => $key],
            ['status' => true] + ($cfg['defaults'] ?? [])
        );
    }
}