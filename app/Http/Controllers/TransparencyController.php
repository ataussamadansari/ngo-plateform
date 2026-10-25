<?php

namespace App\Http\Controllers;

use App\Models\Campaign;
use App\Models\Donation;
use App\Models\FundDistribution;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TransparencyController extends Controller
{
    /**
     * Display the public transparency ledger with verified financials and proof items.
     */
    public function index(Request $request)
    {
        // 1. High-level verified financials
        $totalRaised = (float) Donation::where('status', 'verified')->sum('amount');
        $totalDistributed = (float) FundDistribution::where('is_public', true)->sum('amount_spent');
        $netReserve = max(0, $totalRaised - $totalDistributed);
        $totalBeneficiaries = FundDistribution::where('is_public', true)->count();
        $utilizationRate = $totalRaised > 0 ? min(100, round(($totalDistributed / $totalRaised) * 100, 1)) : 0;

        // 2. Category / Cause breakdown
        $categoryBreakdown = FundDistribution::where('is_public', true)
            ->join('campaigns', 'fund_distributions.campaign_id', '=', 'campaigns.id')
            ->join('cause_categories', 'campaigns.category_id', '=', 'cause_categories.id')
            ->select('cause_categories.name', DB::raw('SUM(fund_distributions.amount_spent) as total_spent'), DB::raw('COUNT(fund_distributions.id) as item_count'))
            ->groupBy('cause_categories.id', 'cause_categories.name')
            ->get();

        $generalReliefSpent = (float) FundDistribution::where('is_public', true)->whereNull('campaign_id')->sum('amount_spent');

        // 3. Itemized Public Distributions query
        $query = FundDistribution::public()->with('campaign.category');

        if ($request->filled('campaign')) {
            $query->where('campaign_id', $request->input('campaign'));
        }

        if ($request->filled('search')) {
            $search = trim($request->input('search'));
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhere('beneficiary_name', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%");
            });
        }

        $distributions = $query->paginate(12)->withQueryString();

        $campaigns = Campaign::orderBy('title')->get(['id', 'title', 'slug']);

        return view('transparency.index', compact(
            'totalRaised',
            'totalDistributed',
            'netReserve',
            'totalBeneficiaries',
            'utilizationRate',
            'categoryBreakdown',
            'generalReliefSpent',
            'distributions',
            'campaigns'
        ));
    }

    /**
     * Display a dedicated cause-specific fund utilization breakdown.
     */
    public function campaignLedger(Campaign $campaign)
    {
        $campaign->load('category');

        $distributions = $campaign->fundDistributions()
            ->where('is_public', true)
            ->orderByDesc('distribution_date')
            ->get();

        $goal = (float) $campaign->goal_amount;
        $raised = (float) $campaign->raised_amount;
        $distributed = (float) $campaign->distributed_amount;
        $remaining = max(0, $goal - $raised);
        $utilizationRate = $raised > 0 ? min(100, round(($distributed / $raised) * 100, 1)) : 0;

        return view('transparency.campaign', compact(
            'campaign',
            'distributions',
            'goal',
            'raised',
            'distributed',
            'remaining',
            'utilizationRate'
        ));
    }
}
