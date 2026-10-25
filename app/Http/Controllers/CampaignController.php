<?php

namespace App\Http\Controllers;

use App\Models\Campaign;
use App\Models\CauseCategory;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CampaignController extends Controller
{
    /**
     * Display the public directory of fundraising campaigns.
     */
    public function index(Request $request): View
    {
        $status = $request->query('status', 'active');
        $categoryParam = $request->query('category');
        $search = $request->query('search');

        $query = Campaign::query()->with('category');

        if ($status === 'completed') {
            $query->where('status', 'completed');
        } else {
            // Default to showing active campaigns
            $query->where('status', 'active');
        }

        if (! empty($categoryParam)) {
            $query->whereHas('category', function ($q) use ($categoryParam) {
                $q->where('slug', $categoryParam)
                    ->orWhere('id', $categoryParam);
            });
        }

        if (! empty($search)) {
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhere('short_description', 'like', "%{$search}%");
            });
        }

        $urgentCampaigns = Campaign::active()
            ->urgent()
            ->latest()
            ->take(3)
            ->get();

        $categories = CauseCategory::active()
            ->withCount(['campaigns' => fn ($q) => $q->active()])
            ->orderBy('name')
            ->get();

        $campaigns = $query->latest()->paginate(9)->withQueryString();

        return view('campaigns.index', compact('campaigns', 'categories', 'urgentCampaigns', 'status', 'categoryParam', 'search'));
    }

    /**
     * Display the public campaign detail and high-conversion cause story.
     */
    public function show(Campaign $campaign): View
    {
        if (in_array($campaign->status, ['draft', 'paused'], true)) {
            abort(404);
        }

        $campaign->load('category');

        $recentDonations = $campaign->verifiedDonations()
            ->latest('created_at')
            ->take(10)
            ->get();

        $fundDistributions = $campaign->fundDistributions()
            ->public()
            ->take(5)
            ->get();

        $donorsCount = $campaign->verifiedDonations()->count();

        return view('campaigns.show', compact('campaign', 'recentDonations', 'fundDistributions', 'donorsCount'));
    }
}
