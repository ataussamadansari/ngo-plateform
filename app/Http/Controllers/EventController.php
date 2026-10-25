<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterEventRequest;
use App\Models\Event;
use App\Models\Volunteer;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class EventController extends Controller
{
    /**
     * Display a listing of upcoming and past public community events.
     */
    public function index(Request $request): View
    {
        $type = $request->query('type', 'upcoming');
        $search = $request->query('search');

        $query = $type === 'past' ? Event::past() : Event::upcoming();

        if (! empty($search)) {
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhere('location_name', 'like', "%{$search}%")
                    ->orWhere('address', 'like', "%{$search}%");
            });
        }

        $events = $query->withCount('registrations')->paginate(9)->withQueryString();

        return view('events.index', compact('events', 'type', 'search'));
    }

    /**
     * Display the specified event details and RSVP registration form.
     */
    public function show(Event $event): View
    {
        $event->loadCount('registrations');

        $isFull = $event->max_participants && $event->registrations_count >= $event->max_participants;

        return view('events.show', compact('event', 'isFull'));
    }

    /**
     * Store a new participant or volunteer RSVP for the event.
     */
    public function register(RegisterEventRequest $request, Event $event): RedirectResponse
    {
        if (! in_array($event->status, ['upcoming', 'ongoing'], true)) {
            return back()->with('error', 'Registration for this event is currently closed.');
        }

        if ($event->max_participants && $event->registrations()->count() >= $event->max_participants) {
            return back()->with('error', 'This event has reached full participant capacity.');
        }

        if ($event->registrations()->where('participant_phone', $request->participant_phone)->exists()) {
            return back()->with('error', 'A registration with this phone number has already been recorded for this event.');
        }

        // Auto-match approved volunteer record
        $volunteer = null;
        if (! empty($request->participant_phone) || ! empty($request->participant_email)) {
            $volunteer = Volunteer::where('phone', $request->participant_phone)
                ->when($request->participant_email, fn ($q) => $q->orWhere('email', $request->participant_email))
                ->first();
        }

        $event->registrations()->create([
            'volunteer_id' => $volunteer?->id,
            'participant_name' => $request->participant_name,
            'participant_phone' => $request->participant_phone,
            'participant_email' => $request->participant_email,
            'role_assigned' => $volunteer ? 'Volunteer' : 'Participant',
            'attendance_status' => 'registered',
        ]);

        return back()->with('success', "RSVP confirmed! We look forward to seeing you at {$event->title}.");
    }
}
