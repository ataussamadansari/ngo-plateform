<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCampaignRequest;
use App\Http\Requests\UpdateCampaignRequest;
use App\Models\Campaign;
use App\Models\CauseCategory;
use Illuminate\Http\Request;

class AdminCampaignController extends Controller
{
    /**
     * Display a listing of campaigns with financial and status metrics.
     */
    public function index(Request $request)
    {
        $totalCampaigns = Campaign::count();
        $activeCampaigns = Campaign::where('status', 'active')->count();
        $totalGoal = (float) Campaign::sum('goal_amount');
        $totalRaised = (float) Campaign::sum('raised_amount');

        $query = Campaign::with('category')->withCount('verifiedDonations');

        if ($request->filled('status') && in_array($request->input('status'), ['draft', 'active', 'completed', 'paused'])) {
            $query->where('status', $request->input('status'));
        }

        if ($request->filled('category_id')) {
            $query->where('category_id', $request->input('category_id'));
        }

        if ($request->filled('search')) {
            $search = trim($request->input('search'));
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhere('short_description', 'like', "%{$search}%");
            });
        }

        $campaigns = $query->orderByDesc('is_urgent')
            ->orderByDesc('created_at')
            ->paginate(12)
            ->withQueryString();

        $categories = CauseCategory::orderBy('name')->get(['id', 'name']);

        return view('admin.campaigns.index', compact(
            'campaigns',
            'categories',
            'totalCampaigns',
            'activeCampaigns',
            'totalGoal',
            'totalRaised'
        ));
    }

    /**
     * Show the form for creating a new campaign.
     */
    public function create()
    {
        $categories = CauseCategory::active()->orderBy('name')->get(['id', 'name']);

        return view('admin.campaigns.create', compact('categories'));
    }

    /**
     * Store a newly created campaign in storage.
     */
    public function store(StoreCampaignRequest $request)
    {
        $data = $request->validated();

        if ($request->hasFile('thumbnail_image')) {
            $data['thumbnail_image'] = $request->file('thumbnail_image')->store('campaigns/thumbnails', 'public');
        }

        if ($request->hasFile('gallery_images')) {
            $gallery = [];
            foreach ($request->file('gallery_images') as $file) {
                $gallery[] = $file->store('campaigns/galleries', 'public');
            }
            $data['gallery_images'] = $gallery;
        }

        $campaign = Campaign::create($data);

        return redirect()
            ->route('admin.campaigns.index')
            ->with('success', 'Campaign "'.$campaign->title.'" created successfully.');
    }

    /**
     * Show the form for editing the specified campaign.
     */
    public function edit(Campaign $campaign)
    {
        $categories = CauseCategory::orderBy('name')->get(['id', 'name']);

        return view('admin.campaigns.edit', compact('campaign', 'categories'));
    }

    /**
     * Update the specified campaign in storage.
     */
    public function update(UpdateCampaignRequest $request, Campaign $campaign)
    {
        $data = $request->validated();

        if ($request->hasFile('thumbnail_image')) {
            $data['thumbnail_image'] = $request->file('thumbnail_image')->store('campaigns/thumbnails', 'public');
        }

        if ($request->hasFile('gallery_images')) {
            $existing = $campaign->gallery_images ?? [];
            foreach ($request->file('gallery_images') as $file) {
                $existing[] = $file->store('campaigns/galleries', 'public');
            }
            $data['gallery_images'] = $existing;
        }

        $campaign->update($data);

        return redirect()
            ->route('admin.campaigns.index')
            ->with('success', 'Campaign "'.$campaign->title.'" updated successfully.');
    }

    /**
     * Quick status transition for a campaign (draft, active, completed, paused).
     */
    public function toggleStatus(Request $request, Campaign $campaign)
    {
        $validated = $request->validate([
            'status' => ['required', 'in:draft,active,completed,paused'],
        ]);

        $campaign->update(['status' => $validated['status']]);

        return redirect()
            ->back()
            ->with('success', 'Campaign status updated to '.ucfirst($validated['status']).'.');
    }
}
