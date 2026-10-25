<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Campaign;
use App\Models\ContactInquiry;
use App\Models\Donation;
use App\Models\FundDistribution;
use App\Models\Volunteer;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AdminDashboardController extends Controller
{
    /**
     * Display the central executive administrative dashboard with live financial metrics,
     * quick verification queues, and operational status feeds.
     */
    public function index(Request $request): View
    {
        // 1. Live Verified Financial Metrics
        $totalVerifiedFunds = (float) Donation::where('status', 'verified')->sum('amount');
        $totalDistributedFunds = (float) FundDistribution::sum('amount_spent');
        $availableBalance = max(0.00, $totalVerifiedFunds - $totalDistributedFunds);

        // 2. Queue & Status Counters
        $pendingDonationsCount = (int) Donation::where('status', 'pending')->count();
        $pendingVolunteersCount = (int) Volunteer::where('status', 'pending')->count();
        $pendingInquiriesCount = (int) ContactInquiry::where('status', 'pending')->count();
        $activeCampaignsCount = (int) Campaign::where('status', 'active')->count();
        $totalDonorsCount = (int) Donation::where('status', 'verified')->distinct('phone')->count();

        // 3. Quick-Action Triage Queues
        $pendingDonations = Donation::where('status', 'pending')
            ->with('campaign')
            ->latest()
            ->take(5)
            ->get();

        $pendingVolunteers = Volunteer::where('status', 'pending')
            ->latest()
            ->take(5)
            ->get();

        // 4. Operational Feeds: Active Campaigns & Recent Ground Disbursements
        $activeCampaigns = Campaign::where('status', 'active')
            ->with('category')
            ->latest()
            ->take(4)
            ->get();

        $recentDistributions = FundDistribution::with('campaign')
            ->latest('distribution_date')
            ->take(5)
            ->get();

        return view('admin.dashboard', compact(
            'totalVerifiedFunds',
            'totalDistributedFunds',
            'availableBalance',
            'pendingDonationsCount',
            'pendingVolunteersCount',
            'pendingInquiriesCount',
            'activeCampaignsCount',
            'totalDonorsCount',
            'pendingDonations',
            'pendingVolunteers',
            'activeCampaigns',
            'recentDistributions'
        ));
    }
}
