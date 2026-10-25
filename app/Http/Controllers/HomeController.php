<?php

namespace App\Http\Controllers;

use App\Models\Campaign;
use App\Models\CauseCategory;
use App\Models\Donation;
use App\Models\Event;
use App\Models\FundDistribution;
use App\Models\Volunteer;
use Illuminate\Http\Request;
use Illuminate\View\View;

class HomeController extends Controller
{
    /**
     * Display the dynamic public homepage with live impact metrics, urgent causes, and ground transparency highlights.
     */
    public function index(Request $request): View
    {
        // 1. Live Verified Financial & Activity Metrics
        $totalRaised = (float) Donation::where('status', 'verified')->sum('amount');
        $totalDistributed = (float) FundDistribution::where('is_public', true)->sum('amount_spent');
        $volunteerCount = (int) Volunteer::where('status', 'approved')->count();
        $activeCausesCount = (int) Campaign::where('status', 'active')->count();

        // 2. Urgent Causes & High-Priority Campaigns
        $urgentCampaigns = Campaign::where('status', 'active')
            ->where('is_urgent', true)
            ->with('category')
            ->latest()
            ->take(3)
            ->get();

        if ($urgentCampaigns->isEmpty()) {
            $urgentCampaigns = Campaign::where('status', 'active')
                ->with('category')
                ->latest()
                ->take(3)
                ->get();
        }

        // 3. Ground Proof: Recent Verified Transparency Distributions
        $recentDistributions = FundDistribution::with('campaign')
            ->latest('distribution_date')
            ->take(3)
            ->get();

        // 4. Upcoming Community Relief Drives & Events
        $upcomingEvents = Event::upcoming()
            ->take(3)
            ->get();

        // 5. Active Cause Categories for Donor Exploration
        $categories = CauseCategory::where('is_active', true)->get();

        return view('welcome', compact(
            'totalRaised',
            'totalDistributed',
            'volunteerCount',
            'activeCausesCount',
            'urgentCampaigns',
            'recentDistributions',
            'upcomingEvents',
            'categories'
        ));
    }
}
