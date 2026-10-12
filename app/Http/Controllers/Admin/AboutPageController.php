<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AboutBelief;
use App\Models\AboutPage;
use App\Models\AboutStat;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class AboutPageController extends Controller
{
    public function index()
    {
        $about   = AboutPage::first() ?? new AboutPage();
        $stats   = AboutStat::ordered()->get();
        $beliefs = AboutBelief::ordered()->get();

        return view('admin.about.index', compact('about', 'stats', 'beliefs'));
    }

    public function update(Request $request)
    {
        $data = $request->validate([
            // SEO
            'meta_title'           => 'nullable|string|max:255',
            'meta_description'     => 'nullable|string|max:500',
            // Hero
            'hero_badge'           => 'nullable|string|max:255',
            'hero_title'           => 'nullable|string|max:255',
            'hero_title_highlight' => 'nullable|string|max:255',
            'hero_description'     => 'nullable|string',
            // Story
            'story_badge'          => 'nullable|string|max:255',
            'story_heading'        => 'nullable|string|max:255',
            'story_paragraph_1'    => 'nullable|string',
            'story_paragraph_2'    => 'nullable|string',
            'story_image'          => 'nullable|image|mimes:jpg,jpeg,png,webp|max:3072',
            'story_image_alt'      => 'nullable|string|max:255',
            // Beliefs heading
            'beliefs_badge'        => 'nullable|string|max:255',
            'beliefs_heading'      => 'nullable|string|max:255',
            'beliefs_description'  => 'nullable|string',
            // Promise
            'promise_badge'        => 'nullable|string|max:255',
            'promise_heading'      => 'nullable|string|max:255',
            'promise_description'  => 'nullable|string',
            'promise_btn1_text'    => 'nullable|string|max:255',
            'promise_btn1_url'     => 'nullable|string|max:255',
            'promise_btn2_text'    => 'nullable|string|max:255',
            'promise_btn2_url'     => 'nullable|string|max:255',

            // Stats repeater
            'stats'              => 'nullable|array',
            'stats.*.id'         => 'nullable|integer',
            'stats.*.value'      => 'required|string|max:50',
            'stats.*.label'      => 'required|string|max:100',
            'stats.*.color'      => 'required|in:navy,orange',
            'stats.*.sort_order' => 'nullable|integer|min:0',
            'stats.*.status'     => 'nullable|boolean',

            // Beliefs repeater
            'beliefs'               => 'nullable|array',
            'beliefs.*.id'          => 'nullable|integer',
            'beliefs.*.title'       => 'required|string|max:100',
            'beliefs.*.description' => 'nullable|string',
            'beliefs.*.icon'        => 'nullable|string|max:100',
            'beliefs.*.color'       => 'required|in:blue,orange,mint,yellow',
            'beliefs.*.sort_order'  => 'nullable|integer|min:0',
            'beliefs.*.status'      => 'nullable|boolean',
        ], [
            'stats.*.value.required'  => 'Every stat needs a value.',
            'stats.*.label.required'  => 'Every stat needs a label.',
            'beliefs.*.title.required' => 'Every belief card needs a title.',
        ]);

        DB::transaction(function () use ($request, $data) {
            $about = AboutPage::first() ?? new AboutPage();

            $pageData = Arr::except($data, ['stats', 'beliefs', 'story_image']);

            if ($request->hasFile('story_image')) {
                // remove the old uploaded file (external URLs are left alone)
                if ($about->story_image && !Str::startsWith($about->story_image, ['http://', 'https://'])) {
                    @unlink(public_path($about->story_image));
                }
                $file = $request->file('story_image');
                $name = 'about_' . time() . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('uploads/about'), $name);
                $pageData['story_image'] = 'uploads/about/' . $name;
            }

            $about->fill($pageData)->save();

            $this->syncItems(AboutStat::class,   $data['stats']   ?? []);
            $this->syncItems(AboutBelief::class, $data['beliefs'] ?? []);
        });

        return redirect()->route('admin.about.index')->with('success', 'About Us page updated successfully.');
    }

    /**
     * Update rows that have an id, create rows that don't,
     * and delete any existing rows that were not submitted.
     */
    private function syncItems(string $modelClass, array $rows): void
    {
        $keepIds = [];

        foreach (array_values($rows) as $i => $row) {
            $payload               = Arr::except($row, ['id']);
            $payload['sort_order'] = $payload['sort_order'] ?? ($i + 1);
            $payload['status']     = (int) ($row['status'] ?? 0);

            $model = !empty($row['id']) ? $modelClass::find($row['id']) : null;

            if ($model) {
                $model->update($payload);
            } else {
                $model = $modelClass::create($payload);
            }

            $keepIds[] = $model->id;
        }

        $modelClass::whereNotIn('id', $keepIds)->delete();
    }
}