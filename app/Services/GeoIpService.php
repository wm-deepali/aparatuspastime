<?php

namespace App\Services;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

class GeoIpService
{
    public static function lookup(?string $ip): array
    {
        $empty = ['city' => null, 'country' => null, 'isp' => null];

        // Skip empty, local and private/reserved IPs (e.g. 127.0.0.1 on localhost)
        if (!$ip || !filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE)) {
            return $empty;
        }

        return Cache::remember("geoip:{$ip}", now()->addDay(), function () use ($ip, $empty) {
            try {
                $response = Http::timeout(3)
                    ->get("http://ip-api.com/json/{$ip}", [
                        'fields' => 'status,country,city,isp',
                    ]);

                if ($response->successful() && $response->json('status') === 'success') {
                    return [
                        'city'    => $response->json('city'),
                        'country' => $response->json('country'),
                        'isp'     => $response->json('isp'),
                    ];
                }
            } catch (\Throwable $e) {
                // Geo lookup must never break login/logout
            }

            return $empty;
        });
    }
}