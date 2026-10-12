<?php

namespace Database\Seeders;

use App\Models\DynamicPage;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

/**
 * Imports the existing static policy blade files into the dynamic_pages table.
 * Run it BEFORE removing the old Route::view lines / blade files.
 *
 * Safe to run again: pages that already exist are left untouched (admin edits are never overwritten).
 */
class DynamicPageSeeder extends Seeder
{
    // slug => blade file name in resources/views/front-pages/
    private const PAGES = [
        'cancellation-policy' => 'cancellation-policy',
        'cookie-policy'       => 'cookie-policy',
        'privacy-policy'      => 'privacy-policy',
        'payment-policy'      => 'payment-policy',
        'shipping-policy'     => 'shipping-policy',
        'returns'             => 'returns',
        'terms'               => 'terms',
    ];

    public function run(): void
    {
        foreach (self::PAGES as $slug => $file) {
            $path = resource_path("views/front-pages/{$file}.blade.php");

            if (!file_exists($path)) {
                $this->warn("SKIPPED {$slug}: {$file}.blade.php not found");
                continue;
            }

            $src = file_get_contents($path);

            $content = $this->extractContent($src);
            if ($content === null || trim($content) === '') {
                $this->warn("SKIPPED {$slug}: could not find the <div class=\"space-y-4\"> content block");
                continue;
            }

            if (str_contains($content, '{{') || str_contains($content, '{!!') || preg_match('/@(php|include|if|foreach)\b/', $content)) {
                $this->warn("CHECK {$slug}: content has Blade code. It was imported as plain text, please review it in admin.");
            }

            // badge, heading, date line
            $badge   = preg_match('/<span class="inline-block[^>]*>(.*?)<\/span>/s', $src, $m) ? trim(strip_tags($m[1])) : null;
            $heading = preg_match('/<h1[^>]*>(.*?)<\/h1>/s', $src, $m) ? trim(strip_tags($m[1])) : ucwords(str_replace('-', ' ', $slug));

            $dateLabel = 'Last Updated';
            $date      = null;
            if (preg_match('/(Last Updated|Effective Date):\s*([A-Za-z]+\s+\d{4})/', $src, $m)) {
                $dateLabel = $m[1];
                try {
                    $date = Carbon::parse('1 ' . $m[2])->toDateString();
                } catch (\Throwable $e) {
                    $date = null;
                }
            }

            // SEO from the @section lines, if present
            $metaTitle = preg_match("/@section\('title',\s*'((?:[^'\\\\]|\\\\.)*)'/", $src, $m) ? stripslashes($m[1]) : null;
            $metaDesc  = preg_match("/@section\('meta_description',\s*'((?:[^'\\\\]|\\\\.)*)'/", $src, $m) ? stripslashes($m[1]) : null;

            // strip the trailing " | Aparatus Pastime" so the view can add it once
            if ($metaTitle) {
                $metaTitle = trim(preg_replace('/\s*\|\s*Aparatus Pastime.*$/i', '', $metaTitle));
            }

            DynamicPage::firstOrCreate(
                ['slug' => $slug],
                [
                    'badge_text'       => $badge,
                    'heading'          => $heading,
                    'date_label'       => $dateLabel,
                    'effective_date'   => $date,
                    'content'          => trim($content),
                    'meta_title'       => $metaTitle,
                    'meta_description' => $metaDesc,
                    'status'           => true,
                    'is_system'        => true,
                ]
            );

            $this->info("Imported {$slug}");
        }
    }

    /**
     * Inner HTML of the first <div class="space-y-4"> (matches nested divs).
     */
    private function extractContent(string $src): ?string
    {
        $open = '<div class="space-y-4">';
        $start = strpos($src, $open);
        if ($start === false) {
            return null;
        }

        $pos   = $start + strlen($open);
        $begin = $pos;
        $depth = 1;

        while ($depth > 0 && preg_match('/<div\b|<\/div>/i', $src, $m, PREG_OFFSET_CAPTURE, $pos)) {
            $tag = strtolower($m[0][0]);
            $pos = $m[0][1] + strlen($m[0][0]);

            if ($tag === '</div>') {
                $depth--;
                if ($depth === 0) {
                    return substr($src, $begin, $m[0][1] - $begin);
                }
            } else {
                $depth++;
            }
        }

        return null;
    }

    private function warn(string $msg): void
    {
        $this->command?->warn($msg);
    }

    private function info(string $msg): void
    {
        $this->command?->info($msg);
    }
}