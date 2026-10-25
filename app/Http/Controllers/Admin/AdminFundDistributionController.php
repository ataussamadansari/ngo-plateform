<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreFundDistributionRequest;
use App\Models\Campaign;
use App\Models\FundDistribution;
use App\Services\FundDistributionService;
use Illuminate\Http\Request;

class AdminFundDistributionController extends Controller
{
    /**
     * Display a listing of recorded fund distributions with filter metrics.
     */
    public function index(Request $request)
    {
        $totalDistributed = (float) FundDistribution::sum('amount_spent');
        $totalBeneficiaries = FundDistribution::count();
        $campaignsSupported = FundDistribution::whereNotNull('campaign_id')->distinct('campaign_id')->count('campaign_id');

        $query = FundDistribution::with(['campaign', 'createdBy']);

        // Filter by campaign
        if ($request->filled('campaign_id')) {
            $query->where('campaign_id', $request->input('campaign_id'));
        }

        // Filter by visibility (all, public, internal)
        if ($request->filled('visibility')) {
            if ($request->input('visibility') === 'public') {
                $query->where('is_public', true);
            } elseif ($request->input('visibility') === 'internal') {
                $query->where('is_public', false);
            }
        }

        // Search query
        if ($request->filled('search')) {
            $search = trim($request->input('search'));
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhere('beneficiary_name', 'like', "%{$search}%")
                    ->orWhere('payment_reference', 'like', "%{$search}%");
            });
        }

        $distributions = $query->orderByDesc('distribution_date')
            ->orderByDesc('id')
            ->paginate(15)
            ->withQueryString();

        $campaigns = Campaign::orderBy('title')->get(['id', 'title']);

        return view('admin.distributions.index', compact(
            'distributions',
            'campaigns',
            'totalDistributed',
            'totalBeneficiaries',
            'campaignsSupported'
        ));
    }

    /**
     * Show the form for creating a new fund distribution entry.
     */
    public function create()
    {
        $campaigns = Campaign::orderBy('title')->get(['id', 'title']);

        return view('admin.distributions.create', compact('campaigns'));
    }

    /**
     * Store a newly created fund distribution in storage.
     */
    public function store(StoreFundDistributionRequest $request, FundDistributionService $service)
    {
        $distribution = $service->recordDistribution(
            $request->validated(),
            $request->file('proof_bill_image'),
            $request->file('impact_photos') ?? []
        );

        return redirect()
            ->route('admin.distributions.index')
            ->with('success', 'Fund distribution of ₹'.number_format($distribution->amount_spent, 2).' successfully recorded.');
    }

    /**
     * Display the specified fund distribution details for modal inspection.
     */
    public function show(FundDistribution $distribution)
    {
        $distribution->load(['campaign', 'createdBy']);

        return response()->json($distribution);
    }
}
