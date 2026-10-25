<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Volunteer;
use App\Services\VolunteerCodeService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class AdminVolunteerController extends Controller
{
    /**
     * Display a listing of volunteer applicants with status filters and search.
     */
    public function index(Request $request): View
    {
        $status = $request->query('status', 'all');
        $city = $request->query('city');
        $skill = $request->query('skill');
        $search = $request->query('search');

        $query = Volunteer::query();

        if ($status !== 'all') {
            $query->where('status', $status);
        }

        if (! empty($city)) {
            $query->where('city', $city);
        }

        if (! empty($skill)) {
            $query->whereJsonContains('skills', $skill);
        }

        if (! empty($search)) {
            $query->where(function ($q) use ($search) {
                $q->where('full_name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('phone', 'like', "%{$search}%")
                    ->orWhere('volunteer_code', 'like', "%{$search}%");
            });
        }

        $volunteers = $query->latest()->paginate(15)->withQueryString();

        $totalApplicants = Volunteer::count();
        $pendingCount = Volunteer::pending()->count();
        $approvedCount = Volunteer::approved()->count();
        $cities = Volunteer::distinct()->whereNotNull('city')->pluck('city')->sort()->values();

        return view('admin.volunteers.index', compact(
            'volunteers',
            'totalApplicants',
            'pendingCount',
            'approvedCount',
            'status',
            'city',
            'skill',
            'search',
            'cities'
        ));
    }

    /**
     * Display a single volunteer application profile and ID verification.
     */
    public function show(Volunteer $volunteer): View
    {
        $volunteer->load('eventRegistrations.event');

        return view('admin.volunteers.show', compact('volunteer'));
    }

    /**
     * Approve the volunteer application and assign a sequential identification code.
     */
    public function approve(Volunteer $volunteer, VolunteerCodeService $codeService): RedirectResponse
    {
        DB::transaction(function () use ($volunteer, $codeService) {
            $code = $volunteer->volunteer_code ?: $codeService->generateNextCode();

            $volunteer->update([
                'status' => 'approved',
                'volunteer_code' => $code,
                'joined_at' => $volunteer->joined_at ?: now()->toDateString(),
            ]);
        });

        return back()->with('success', "Volunteer {$volunteer->full_name} has been approved with identification code: {$volunteer->volunteer_code}");
    }

    /**
     * Reject the volunteer application.
     */
    public function reject(Volunteer $volunteer): RedirectResponse
    {
        $volunteer->update([
            'status' => 'rejected',
        ]);

        return back()->with('info', "Volunteer application for {$volunteer->full_name} has been marked as rejected.");
    }
}
