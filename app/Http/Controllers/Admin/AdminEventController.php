<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreEventRequest;
use App\Http\Requests\UpdateEventRequest;
use App\Models\Event;
use App\Models\EventRegistration;
use App\Models\Volunteer;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;

class AdminEventController extends Controller
{
    /**
     * Display a listing of events with participant metrics.
     */
    public function index(Request $request): View
    {
        $status = $request->query('status', 'all');
        $search = $request->query('search');

        $query = Event::query()->withCount('registrations');

        if ($status !== 'all') {
            $query->where('status', $status);
        }

        if (! empty($search)) {
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhere('location_name', 'like', "%{$search}%");
            });
        }

        $events = $query->orderByDesc('event_date')->paginate(12)->withQueryString();

        $totalEvents = Event::count();
        $upcomingCount = Event::where('status', 'upcoming')->where('event_date', '>=', now()->toDateString())->count();
        $totalRegistrations = EventRegistration::count();

        return view('admin.events.index', compact(
            'events',
            'totalEvents',
            'upcomingCount',
            'totalRegistrations',
            'status',
            'search'
        ));
    }

    /**
     * Show the form for creating a new event.
     */
    public function create(): View
    {
        return view('admin.events.create');
    }

    /**
     * Store a newly created event in storage.
     */
    public function store(StoreEventRequest $request): RedirectResponse
    {
        $bannerPath = $request->file('banner_image')->store('events/banners', 'public');

        $slug = $request->slug ? Str::slug($request->slug) : Str::slug($request->title);
        $originalSlug = $slug;
        $counter = 1;
        while (Event::where('slug', $slug)->exists()) {
            $slug = "{$originalSlug}-{$counter}";
            $counter++;
        }

        Event::create([
            'title' => $request->title,
            'slug' => $slug,
            'description' => $request->description,
            'banner_image' => $bannerPath,
            'location_name' => $request->location_name,
            'address' => $request->address,
            'google_map_link' => $request->google_map_link,
            'event_date' => $request->event_date,
            'start_time' => $request->start_time,
            'end_time' => $request->end_time,
            'max_participants' => $request->max_participants,
            'status' => $request->status,
        ]);

        return redirect()->route('admin.events.index')->with('success', 'Event successfully created.');
    }

    /**
     * Show the form for editing the specified event.
     */
    public function edit(Event $event): View
    {
        return view('admin.events.edit', compact('event'));
    }

    /**
     * Update the specified event in storage.
     */
    public function update(UpdateEventRequest $request, Event $event): RedirectResponse
    {
        $data = $request->except(['banner_image', 'slug']);

        if ($request->hasFile('banner_image')) {
            $data['banner_image'] = $request->file('banner_image')->store('events/banners', 'public');
        }

        if ($request->filled('slug')) {
            $data['slug'] = Str::slug($request->slug);
        }

        $event->update($data);

        return redirect()->route('admin.events.index')->with('success', 'Event successfully updated.');
    }

    /**
     * Display the participant roster and attendance sheet for the event.
     */
    public function participants(Request $request, Event $event): View
    {
        $attendanceStatus = $request->query('status', 'all');
        $search = $request->query('search');

        $query = $event->registrations()->with('volunteer');

        if ($attendanceStatus !== 'all') {
            $query->where('attendance_status', $attendanceStatus);
        }

        if (! empty($search)) {
            $query->where(function ($q) use ($search) {
                $q->where('participant_name', 'like', "%{$search}%")
                    ->orWhere('participant_phone', 'like', "%{$search}%")
                    ->orWhere('participant_email', 'like', "%{$search}%");
            });
        }

        $participants = $query->latest()->paginate(25)->withQueryString();

        $totalRegistrations = $event->registrations()->count();
        $attendedCount = $event->registrations()->where('attendance_status', 'attended')->count();
        $absentCount = $event->registrations()->where('attendance_status', 'absent')->count();

        return view('admin.events.participants', compact(
            'event',
            'participants',
            'attendanceStatus',
            'search',
            'totalRegistrations',
            'attendedCount',
            'absentCount'
        ));
    }

    /**
     * Update the attendance status of a registered participant.
     */
    public function updateAttendance(Request $request, Event $event, EventRegistration $registration): RedirectResponse
    {
        $request->validate([
            'attendance_status' => ['required', 'in:registered,attended,absent'],
        ]);

        $registration->update([
            'attendance_status' => $request->attendance_status,
        ]);

        return back()->with('success', "Attendance updated to {$request->attendance_status} for {$registration->participant_name}.");
    }

    /**
     * Manually record an on-spot participant or volunteer at the event venue.
     */
    public function addParticipant(Request $request, Event $event): RedirectResponse
    {
        $request->validate([
            'participant_name' => ['required', 'string', 'max:150'],
            'participant_phone' => ['required', 'string', 'max:20'],
            'participant_email' => ['nullable', 'email', 'max:150'],
            'role_assigned' => ['nullable', 'string', 'max:100'],
            'attendance_status' => ['required', 'in:registered,attended,absent'],
        ]);

        $volunteer = Volunteer::where('phone', $request->participant_phone)
            ->when($request->participant_email, fn ($q) => $q->orWhere('email', $request->participant_email))
            ->first();

        $event->registrations()->create([
            'volunteer_id' => $volunteer?->id,
            'participant_name' => $request->participant_name,
            'participant_phone' => $request->participant_phone,
            'participant_email' => $request->participant_email,
            'role_assigned' => $request->role_assigned ?: ($volunteer ? 'Volunteer' : 'Participant'),
            'attendance_status' => $request->attendance_status,
        ]);

        return back()->with('success', "Participant {$request->participant_name} recorded on roster.");
    }
}
