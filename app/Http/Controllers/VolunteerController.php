<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreVolunteerRequest;
use App\Models\Volunteer;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class VolunteerController extends Controller
{
    /**
     * Predefined volunteer skill domains.
     */
    protected array $skills = [
        'Healthcare & Medical Aid',
        'Child Education & Tutoring',
        'Disaster Relief & Ground Operations',
        'Food Preparation & Ration Distribution',
        'Community Outreach & Field Surveys',
        'Event Coordination & Logistics',
        'Media, Photography & Storytelling',
        'Fundraising & Campaign Advocacy',
    ];

    /**
     * Show the volunteer application form.
     */
    public function create(): View
    {
        return view('volunteers.create', [
            'skills' => $this->skills,
        ]);
    }

    /**
     * Store a newly submitted volunteer application.
     */
    public function store(StoreVolunteerRequest $request): RedirectResponse
    {
        $photoPath = null;
        if ($request->hasFile('profile_photo')) {
            $photoPath = $request->file('profile_photo')->store('volunteers/photos', 'public');
        }

        $idProofPath = null;
        if ($request->hasFile('id_proof')) {
            $idProofPath = $request->file('id_proof')->store('volunteers/id_proofs', 'public');
        }

        $volunteer = Volunteer::create([
            'full_name' => $request->full_name,
            'email' => $request->email,
            'phone' => $request->phone,
            'city' => $request->city,
            'address' => $request->address,
            'occupation' => $request->occupation,
            'skills' => $request->skills,
            'availability' => $request->availability,
            'profile_photo' => $photoPath,
            'id_proof_path' => $idProofPath,
            'status' => 'pending',
        ]);

        return redirect()->route('volunteers.success')
            ->with('applicant_name', $volunteer->full_name);
    }

    /**
     * Show the application success acknowledgment page.
     */
    public function success(): View
    {
        return view('volunteers.success');
    }
}
