<?php

use App\Models\SiteSetting;
use Illuminate\Support\Facades\Cache;

if (! function_exists('setting')) {
    /**
     * Retrieve a cached site setting by key, with optional default fallback.
     */
    function setting(string $key, mixed $default = null): mixed
    {
        try {
            $settings = Cache::rememberForever('site_settings', function () {
                return SiteSetting::all()->pluck('value', 'key')->toArray();
            });

            return $settings[$key] ?? $default;
        } catch (Throwable) {
            return $default;
        }
    }
}
