<?php

namespace App\Console\Commands;

use App\Models\City;
use App\Models\Pincode;
use App\Models\State;
use Illuminate\Console\Command;

class ImportPincodes extends Command
{
    protected $signature = 'pincodes:import {file=pincodes.csv}';
    protected $description = 'Import India pincodes, matched to existing states/cities (does not create new ones)';

    public function handle()
    {
        $path = storage_path('app/' . $this->argument('file'));
        if (!is_file($path)) {
            $this->error("File not found: $path");
            return 1;
        }

        $h = fopen($path, 'r');
        $header = fgetcsv($h);
        $header[0] = ltrim($header[0], "\xEF\xBB\xBF");
        $header = array_map(fn($c) => strtolower(trim($c)), $header);

        $col = function (array $names) use ($header) {
            foreach ($names as $n) {
                $i = array_search($n, $header, true);
                if ($i !== false) return $i;
            }
            return false;
        };

        $iPin   = $col(['pincode']);
        $iDist  = $col(['district', 'districtname']);
        $iState = $col(['statename', 'state']);

        if ($iPin === false || $iDist === false || $iState === false) {
            $this->error('CSV me pincode, district(name) aur statename chahiye. Mile: ' . implode(', ', $header));
            return 1;
        }

        if (State::count() === 0) {
            $this->error('states table khaali hai. Pehle locations:import-india chalao.');
            return 1;
        }

        // "Jammu & Kashmir" == "Jammu and Kashmir" == "JAMMU AND KASHMIR"
        $norm = fn(string $v) => preg_replace('/[^a-z0-9]/', '', str_replace('&', 'and', mb_strtolower(trim($v))));

        // India Post ke purane/alag naam -> dr5hn ke naam
        $merged = 'Dadra and Nagar Haveli and Daman and Diu';
        $alias = [];
        foreach ([
            'Orissa'                 => 'Odisha',
            'Pondicherry'            => 'Puducherry',
            'Uttaranchal'            => 'Uttarakhand',
            'Dadra and Nagar Haveli' => $merged,
            'Daman and Diu'          => $merged,
            'The Dadra and Nagar Haveli and Daman and Diu' => $merged,
        ] as $from => $to) {
            $alias[$norm($from)] = $norm($to);
        }

        $states = [];
        foreach (State::select('id', 'name')->get() as $s) {
            $states[$norm($s->name)] = $s->id;
        }

        $cities = [];
        foreach (City::select('id', 'state_id', 'name')->get() as $c) {
            $cities[$c->state_id . '|' . $norm($c->name)] = $c->id;
        }

        $title = fn(string $v) => ucwords(strtolower(trim($v)), " -/()");

        $rows = []; $seen = []; $total = 0;
        $cityMatched = 0; $stateMissing = [];

        $flush = function () use (&$rows, &$total) {
            if ($rows) {
                Pincode::upsert($rows, ['pincode'], ['state_id', 'city_id', 'district', 'updated_at']);
                $total += count($rows);
                $rows = [];
            }
        };

        while (($r = fgetcsv($h)) !== false) {
            $pin = trim($r[$iPin] ?? '');
            if (!preg_match('/^\d{6}$/', $pin) || isset($seen[$pin])) continue;
            $seen[$pin] = true;

            $rawState = trim($r[$iState] ?? '');
            $rawDist  = trim($r[$iDist] ?? '');
            if (strtolower($rawState) === 'na') $rawState = '';
            if (strtolower($rawDist) === 'na')  $rawDist = '';

            $sKey = $norm($rawState);
            $sKey = $alias[$sKey] ?? $sKey;
            $stateId = $states[$sKey] ?? null;

            if (!$stateId && $rawState !== '') {
                $stateMissing[$rawState] = ($stateMissing[$rawState] ?? 0) + 1;
            }

            $cityId = null;
            if ($stateId && $rawDist !== '') {
                $cityId = $cities[$stateId . '|' . $norm($rawDist)] ?? null;
                if ($cityId) $cityMatched++;
            }

            $rows[] = [
                'pincode'        => $pin,
                'state_id'       => $stateId,
                'city_id'        => $cityId,
                'district'       => $rawDist !== '' ? $title($rawDist) : null,
                'is_serviceable' => 1,
                'created_at'     => now(),
                'updated_at'     => now(),
            ];

            if (count($rows) >= 1000) $flush();
        }

        $flush();
        fclose($h);

        $this->info("Imported $total pincodes.");
        $this->info("City matched: $cityMatched | City not matched (district text only): " . ($total - $cityMatched));

        if ($stateMissing) {
            $this->warn('Ye state names states table me nahi mile (state_id null raha):');
            foreach ($stateMissing as $name => $n) {
                $this->line("  - $name ($n pincodes)");
            }
        }
    }
}