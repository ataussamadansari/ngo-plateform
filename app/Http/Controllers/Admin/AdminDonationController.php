<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Campaign;
use App\Models\Donation;
use App\Models\User;
use App\Services\DonationVerificationService;
use DomainException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AdminDonationController extends Controller
{
    /**
     * Display the donation verification queue.
     */
    public function index(Request $request): View
    {
        $status = $request->query('status', 'pending');
        $campaignId = $request->query('campaign_id');
        $paymentMode = $request->query('payment_mode');
        $search = trim((string) $request->query('search', ''));

        $query = Donation::with(['campaign', 'verifiedBy'])->latest();

        if ($status !== 'all') {
            $query->where('status', $status);
        }

        if (! empty($campaignId)) {
            $query->where('campaign_id', $campaignId);
        }

        if (! empty($paymentMode)) {
            $query->where('payment_mode', $paymentMode);
        }

        if (! empty($search)) {
            $query->where(function ($q) use ($search) {
                $q->where('utr_number', 'LIKE', "%{$search}%")
                    ->orWhere('donor_name', 'LIKE', "%{$search}%")
                    ->orWhere('donor_phone', 'LIKE', "%{$search}%")
                    ->orWhere('donor_email', 'LIKE', "%{$search}%")
                    ->orWhere('receipt_number', 'LIKE', "%{$search}%");
            });
        }

        $donations = $query->paginate(15)->withQueryString();

        // Calculate summary metrics
        $pendingCount = Donation::pending()->count();
        $verifiedCount = Donation::verified()->count();
        $rejectedCount = Donation::rejected()->count();
        $totalVerifiedAmount = Donation::verified()->sum('amount');

        $campaigns = Campaign::active()->get();

        return view('admin.donations.index', compact(
            'donations',
            'status',
            'campaignId',
            'paymentMode',
            'search',
            'pendingCount',
            'verifiedCount',
            'rejectedCount',
            'totalVerifiedAmount',
            'campaigns'
        ));
    }

    /**
     * Approve a pending donation.
     */
    public function approve(Request $request, Donation $donation, DonationVerificationService $service): RedirectResponse
    {
        try {
            $adminId = auth()->id() ?? User::where('role', 'super_admin')->value('id');
            $verified = $service->approve($donation, $adminId);

            return back()->with('success', "Donation #{$donation->id} has been verified! Receipt {$verified->receipt_number} issued.");
        } catch (DomainException $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    /**
     * Reject a donation with admin explanation.
     */
    public function reject(Request $request, Donation $donation, DonationVerificationService $service): RedirectResponse
    {
        $request->validate([
            'admin_remarks' => ['required', 'string', 'max:500'],
        ]);

        try {
            $adminId = auth()->id() ?? User::where('role', 'super_admin')->value('id');
            $service->reject($donation, $request->admin_remarks, $adminId);

            return back()->with('success', "Donation #{$donation->id} has been rejected.");
        } catch (DomainException $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    /**
     * Show form to record a direct offline/cash donation.
     */
    public function create(): View
    {
        $campaigns = Campaign::active()->get();

        return view('admin.donations.create', compact('campaigns'));
    }

    /**
     * Store a direct verified offline donation.
     */
    public function store(Request $request, DonationVerificationService $service): RedirectResponse
    {
        $validated = $request->validate([
            'donor_name' => ['required', 'string', 'max:255'],
            'donor_email' => ['nullable', 'email', 'max:255'],
            'donor_phone' => ['required', 'string', 'max:20'],
            'donor_pan' => ['nullable', 'string', 'regex:/^[A-Z]{5}[0-9]{4}[A-Z]{1}$/i'],
            'donor_address' => ['nullable', 'string', 'max:500'],
            'amount' => ['required', 'numeric', 'min:1', 'max:10000000'],
            'payment_mode' => ['required', 'in:upi_qr,bank_transfer,cash'],
            'campaign_id' => ['nullable', 'exists:campaigns,id'],
            'utr_number' => ['nullable', 'string', 'max:100', 'unique:donations,utr_number'],
            'admin_remarks' => ['nullable', 'string', 'max:500'],
            'is_anonymous' => ['nullable', 'boolean'],
        ]);

        $adminId = auth()->id() ?? User::where('role', 'super_admin')->value('id');
        $donation = $service->createDirectVerified($validated, $adminId);

        return redirect()->route('admin.donations.index', ['status' => 'verified'])
            ->with('success', "Offline donation recorded successfully! Receipt {$donation->receipt_number} issued.");
    }
}
