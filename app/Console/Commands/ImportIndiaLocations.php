<?php

namespace App\Console\Commands;

use App\Models\City;
use App\Models\State;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class ImportIndiaLocations extends Command
{
    protected $signature = 'locations:import-india {file=india.json} {--fresh : Truncate pincodes, cities and states first}';
    protected $description = 'Import Indian states and cities from dr5hn JSON';

    public function handle()
    {
        ini_set('memory_limit', '-1');

        $path = storage_path('app/' . $this->argument('file'));
        if (!is_file($path)) {
            $this->error("File not found: $path");
            return 1;
        }

        $data = json_decode(file_get_contents($path), true);
        if (json_last_error() !== JSON_ERROR_NONE) {
            $this->error('Invalid JSON: ' . json_last_error_msg());
            return 1;
        }

        // india.json (single country) ya poori world file, dono chalegi
        $india = null;
        if (isset($data['iso2'])) {
            $india = $data;
        } else {
            foreach ($data as $country) {
                if (($country['iso2'] ?? '') === 'IN') {
                    $india = $country;
                    break;
                }
            }
        }
        unset($data);

        if (!$india || empty($india['states'])) {
            $this->error('India (iso2 = IN) ya uske states file me nahi mile.');
            return 1;
        }

        if ($this->option('fresh')) {
            if (!$this->confirm('Ye pincodes, cities aur states TRUNCATE kar dega. Continue?')) {
                return 0;
            }
            Schema::disableForeignKeyConstraints();
            if (Schema::hasTable('pincodes')) {
                DB::table('pincodes')->truncate();
            }
            City::truncate();
            State::truncate();
            Schema::enableForeignKeyConstraints();
            $this->info('Tables truncated.');
        }

        $sCount = 0;
        $cCount = 0;

        DB::transaction(function () use ($india, &$sCount, &$cCount) {
            foreach ($india['states'] as $s) {
                $stateName = trim($s['name'] ?? '');
                if ($stateName === '') continue;

                $state = State::firstOrCreate(['name' => $stateName]);
                $sCount++;

                $seen = [];
                foreach (($s['cities'] ?? []) as $c) {
                    $cityName = trim($c['name'] ?? '');
                    $key = mb_strtolower($cityName);
                    if ($cityName === '' || isset($seen[$key])) continue;
                    $seen[$key] = true;

                    City::firstOrCreate([
                        'state_id' => $state->id,
                        'name'     => $cityName,
                    ]);
                    $cCount++;
                }
            }
        });

        $this->info("Imported $sCount states and $cCount cities.");
    }
}