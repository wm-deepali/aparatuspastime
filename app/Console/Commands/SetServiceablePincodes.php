<?php

namespace App\Console\Commands;

use App\Models\Pincode;
use App\Models\State;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class SetServiceablePincodes extends Command
{
    protected $signature = 'pincodes:set-serviceable {--dry-run : Sirf count dikhao, update mat karo}';
    protected $description = 'Sirf Delhi NCR ki 6 cities ke pincodes serviceable rakho, baaki sab band';

    public function handle()
    {
        // Delhi: poora state/UT
        $delhiStateIds = State::where('name', 'like', '%delhi%')->pluck('id');

        // Haryana + UP districts (India Post ke naam, lowercase)
        $districts = [
            'faridabad',
            'gurugram', 'gurgaon',
            'gautam buddh nagar', 'gautam buddha nagar', // Noida + Greater Noida
            'ghaziabad',
        ];

        $matches = fn ($q) => $q->where(function ($w) use ($delhiStateIds, $districts) {
            $w->whereIn('state_id', $delhiStateIds)
              ->orWhereIn(DB::raw('LOWER(TRIM(district))'), $districts);
        });

        $will = $matches(Pincode::query())->count();
        $this->info("Serviceable banenge: $will pincodes");

        $matches(Pincode::query())
            ->select('district', DB::raw('COUNT(*) as n'))
            ->groupBy('district')->orderBy('district')->get()
            ->each(fn ($r) => $this->line("  {$r->district}: {$r->n}"));

        if ($this->option('dry-run')) {
            return 0;
        }

        DB::transaction(function () use ($matches) {
            Pincode::query()->update(['is_serviceable' => 0]);
            $matches(Pincode::query())->update(['is_serviceable' => 1]);
        });

        $this->info('Done. Serviceable now: ' . Pincode::serviceable()->count());
    }
}