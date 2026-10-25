<?php

namespace App\Http\Controllers;

use App\Models\Donation;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DonationStatusController extends Controller
{
    /**
     * Display the donation status lookup portal.
     */
    public function index(Request $request): View
    {
        $query = trim((string) $request->query('query', ''));
        $donations = collect();

        if (! empty($query)) {
            // Strip any accidental leading/trailing spaces or hashes
            $cleaned = ltrim($query, '#');
            $digitsOnly = preg_replace('/[^0-9]/', '', $query);

            $donations = Donation::with('campaign')
                ->where('utr_number', $cleaned)
                ->orWhere('receipt_number', $cleaned)
                ->orWhere('donor_phone', $cleaned)
                ->when(strlen($digitsOnly) >= 10, function ($q) use ($digitsOnly) {
                    $last10 = substr($digitsOnly, -10);
                    $q->orWhere('donor_phone', 'LIKE', '%'.$last10);
                })
                ->latest()
                ->get();
        }

        return view('donate.status', compact('donations', 'query'));
    }
}
