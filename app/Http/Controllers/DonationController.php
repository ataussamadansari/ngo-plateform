<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreDonationRequest;
use App\Models\Campaign;
use App\Models\Donation;
use App\Models\PaymentMethod;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DonationController extends Controller
{
    /**
     * Display the donation page with active payment methods and campaigns.
     */
    public function index(Request $request): View
    {
        $upiMethod = PaymentMethod::upi()->active()->first();
        $bankMethod = PaymentMethod::bank()->active()->first();
        $paymentMethods = PaymentMethod::active()->get();

        $campaigns = Campaign::active()->get();
        $selectedCampaignId = $request->query('campaign');

        $recentDonations = Donation::verified()
            ->latest('verified_at')
            ->take(6)
            ->get();

        return view('donate.index', compact(
            'upiMethod',
            'bankMethod',
            'paymentMethods',
            'campaigns',
            'selectedCampaignId',
            'recentDonations'
        ));
    }

    /**
     * Store a newly submitted manual donation proof.
     */
    public function store(StoreDonationRequest $request): RedirectResponse
    {
        $validated = $request->validated();

        // Securely store the uploaded payment proof in storage/app/public/donations
        $screenshotPath = $request->file('payment_screenshot')->store('donations', 'public');

        $donation = Donation::create([
            'campaign_id' => $validated['campaign_id'] ?? null,
            'donor_name' => $validated['donor_name'],
            'donor_email' => $validated['donor_email'],
            'donor_phone' => $validated['donor_phone'],
            'donor_pan' => $validated['donor_pan'] ?? null,
            'donor_address' => $validated['donor_address'] ?? null,
            'amount' => $validated['amount'],
            'payment_mode' => $validated['payment_mode'],
            'utr_number' => $validated['utr_number'],
            'payment_screenshot' => $screenshotPath,
            'donor_message' => $validated['donor_message'] ?? null,
            'is_anonymous' => $request->boolean('is_anonymous'),
            'status' => 'pending',
        ]);

        return redirect()->route('donate.index')->with([
            'success' => 'Thank you! Your donation of ₹'.number_format($donation->amount, 2).' has been recorded with UTR '.$donation->utr_number.'. Our team is verifying your payment against bank records.',
            'submitted_utr' => $donation->utr_number,
        ]);
    }
}
