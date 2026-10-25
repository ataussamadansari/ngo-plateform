<?php

namespace App\Services;

use App\Models\Volunteer;

class VolunteerCodeService
{
    /**
     * Generate the next collision-resistant sequential volunteer identification code.
     * Format: {PREFIX}-VOL-{YEAR}-{SEQUENCE} (e.g. KSF-VOL-2026-0001)
     */
    public function generateNextCode(): string
    {
        $rawPrefix = (string) setting('volunteer_prefix', 'KSF-VOL');
        $prefix = str_ends_with(strtoupper($rawPrefix), 'VOL')
            ? $rawPrefix
            : "{$rawPrefix}-VOL";

        $year = date('Y');

        $count = Volunteer::whereNotNull('volunteer_code')
            ->where('volunteer_code', 'like', "{$prefix}-{$year}-%")
            ->count();

        $sequence = str_pad((string) ($count + 1), 4, '0', STR_PAD_LEFT);
        $code = "{$prefix}-{$year}-{$sequence}";

        // Defensive collision resolution loop
        while (Volunteer::where('volunteer_code', $code)->exists()) {
            $count++;
            $sequence = str_pad((string) ($count + 1), 4, '0', STR_PAD_LEFT);
            $code = "{$prefix}-{$year}-{$sequence}";
        }

        return $code;
    }
}
