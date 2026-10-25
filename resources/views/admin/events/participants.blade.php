@extends('layouts.base')

@section('title', 'Event Roster & Attendance - ' . $event->title)

@section('content')
<div class="bg-slate-900 text-white py-8 border-b border-slate-800">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div>
                <div class="flex items-center gap-2 mb-2">
                    <a href="{{ route('admin.events.index') }}" class="text-xs font-semibold text-slate-400 hover:text-white transition flex items-center gap-1">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                        Back to Events
                    </a>
                    <span class="text-slate-600">/</span>
                    <span class="text-xs font-medium text-slate-400">Roster & Attendance</span>
                </div>
                <div class="flex flex-wrap items-center gap-3">
                    <h1 class="text-2xl sm:text-3xl font-black text-white tracking-tight">
                        {{ $event->title }}
                    </h1>
                    @if($event->status === 'upcoming')
                        <span class="px-2.5 py-0.5 rounded-full text-[11px] font-bold bg-blue-500/20 text-blue-300 border border-blue-500/30">Upcoming</span>
                    @elseif($event->status === 'ongoing')
                        <span class="px-2.5 py-0.5 rounded-full text-[11px] font-bold bg-emerald-500/20 text-emerald-300 border border-emerald-500/30">Ongoing</span>
                    @elseif($event->status === 'completed')
                        <span class="px-2.5 py-0.5 rounded-full text-[11px] font-bold bg-slate-500/20 text-slate-300 border border-slate-500/30">Completed</span>
                    @else
                        <span class="px-2.5 py-0.5 rounded-full text-[11px] font-bold bg-red-500/20 text-red-300 border border-red-500/30">Cancelled</span>
                    @endif
                </div>
                <div class="flex flex-wrap items-center gap-4 text-xs text-slate-400 mt-2">
                    <span class="flex items-center gap-1.5">
                        <svg class="w-3.5 h-3.5 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                        {{ $event->event_date?->format('l, d M Y') }}
                    </span>
                    <span class="flex items-center gap-1.5">
                        <svg class="w-3.5 h-3.5 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        {{ \Carbon\Carbon::parse($event->start_time)->format('h:i A') }}
                    </span>
                    <span class="flex items-center gap-1.5">
                        <svg class="w-3.5 h-3.5 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                        {{ $event->location_name }}
                    </span>
                </div>
            </div>
            <div class="flex items-center gap-3">
                <a href="{{ route('admin.events.edit', $event->id) }}" class="px-4 py-2 rounded-xl bg-slate-800 hover:bg-slate-700 text-slate-200 text-xs font-bold transition border border-slate-700">
                    Edit Event Details
                </a>
                <a href="{{ route('events.show', $event->slug) }}" target="_blank" class="px-4 py-2 rounded-xl bg-primary text-white text-xs font-bold transition hover:opacity-95 shadow-md flex items-center gap-1.5">
                    View Public Page
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                </a>
            </div>
        </div>
    </div>
</div>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 space-y-8">

    @if (session('success'))
        <div class="p-4 rounded-2xl bg-emerald-50 border border-emerald-200 text-emerald-800 text-xs sm:text-sm font-semibold flex items-center justify-between">
            <span class="flex items-center gap-2">
                <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                {{ session('success') }}
            </span>
        </div>
    @endif

    @if ($errors->any())
        <div class="p-4 rounded-2xl bg-red-50 border border-red-200 text-red-800 text-sm">
            <div class="font-bold mb-1">Please fix the following errors:</div>
            <ul class="list-disc pl-6 space-y-1 text-xs">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- Attendance Metrics Strip -->
    <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
        <div class="bg-white rounded-2xl border border-slate-200 p-5 shadow-2xs">
            <span class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-1">Total Registrations</span>
            <div class="flex items-baseline gap-2">
                <span class="text-2xl font-black text-slate-900">{{ number_format($totalRegistrations) }}</span>
                @if($event->max_participants)
                    <span class="text-xs text-slate-500 font-medium">/ {{ number_format($event->max_participants) }} cap</span>
                @else
                    <span class="text-xs text-slate-400 font-medium">(No limit)</span>
                @endif
            </div>
            @if($event->max_participants)
                <div class="w-full bg-slate-100 rounded-full h-1.5 mt-2.5 overflow-hidden">
                    <div class="bg-primary h-1.5 rounded-full" style="width: {{ min(100, round(($totalRegistrations / $event->max_participants) * 100)) }}%"></div>
                </div>
            @endif
        </div>

        <div class="bg-white rounded-2xl border border-slate-200 p-5 shadow-2xs">
            <span class="block text-xs font-bold text-emerald-600 uppercase tracking-wider mb-1">Attended (Present)</span>
            <span class="text-2xl font-black text-emerald-700">{{ number_format($attendedCount) }}</span>
            <span class="block text-[11px] text-slate-400 mt-1">
                {{ $totalRegistrations > 0 ? round(($attendedCount / $totalRegistrations) * 100) : 0 }}% turnout rate
            </span>
        </div>

        <div class="bg-white rounded-2xl border border-slate-200 p-5 shadow-2xs">
            <span class="block text-xs font-bold text-blue-600 uppercase tracking-wider mb-1">Registered (Pending)</span>
            <span class="text-2xl font-black text-blue-700">{{ number_format($totalRegistrations - $attendedCount - $absentCount) }}</span>
            <span class="block text-[11px] text-slate-400 mt-1">Awaiting attendance mark</span>
        </div>

        <div class="bg-white rounded-2xl border border-slate-200 p-5 shadow-2xs">
            <span class="block text-xs font-bold text-red-600 uppercase tracking-wider mb-1">Absent</span>
            <span class="text-2xl font-black text-red-700">{{ number_format($absentCount) }}</span>
            <span class="block text-[11px] text-slate-400 mt-1">Marked no-show</span>
        </div>
    </div>

    <!-- On-Spot Participant Entry Card -->
    <div class="bg-white rounded-3xl border border-slate-200 p-6 shadow-xs">
        <h2 class="text-sm font-black text-slate-900 uppercase tracking-wider mb-4 flex items-center gap-2">
            <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
            Add On-Spot Walk-In Attendee or Volunteer
        </h2>
        <form action="{{ route('admin.events.addParticipant', $event->id) }}" method="POST" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-3">
            @csrf
            <div>
                <label class="block text-[11px] font-bold text-slate-600 uppercase tracking-wider mb-1">Full Name *</label>
                <input type="text" name="participant_name" required placeholder="Attendee name" class="w-full text-xs rounded-xl border border-slate-300 px-3 py-2 text-slate-900 focus:outline-none focus:ring-2 focus:ring-emerald-500">
            </div>
            <div>
                <label class="block text-[11px] font-bold text-slate-600 uppercase tracking-wider mb-1">Phone Number *</label>
                <input type="text" name="participant_phone" required placeholder="10-digit phone" class="w-full text-xs rounded-xl border border-slate-300 px-3 py-2 text-slate-900 focus:outline-none focus:ring-2 focus:ring-emerald-500">
            </div>
            <div>
                <label class="block text-[11px] font-bold text-slate-600 uppercase tracking-wider mb-1">Email (Optional)</label>
                <input type="email" name="participant_email" placeholder="email@example.com" class="w-full text-xs rounded-xl border border-slate-300 px-3 py-2 text-slate-900 focus:outline-none focus:ring-2 focus:ring-emerald-500">
            </div>
            <div>
                <label class="block text-[11px] font-bold text-slate-600 uppercase tracking-wider mb-1">Role Assigned</label>
                <input type="text" name="role_assigned" placeholder="e.g. Volunteer, Participant" value="Participant" class="w-full text-xs rounded-xl border border-slate-300 px-3 py-2 text-slate-900 focus:outline-none focus:ring-2 focus:ring-emerald-500">
            </div>
            <div>
                <label class="block text-[11px] font-bold text-slate-600 uppercase tracking-wider mb-1">Status *</label>
                <div class="flex items-center gap-2">
                    <select name="attendance_status" required class="w-full text-xs rounded-xl border border-slate-300 px-3 py-2 text-slate-900 bg-white focus:outline-none focus:ring-2 focus:ring-emerald-500">
                        <option value="attended" selected>Attended (Present)</option>
                        <option value="registered">Registered</option>
                        <option value="absent">Absent</option>
                    </select>
                    <button type="submit" class="px-4 py-2 rounded-xl bg-emerald-600 text-white font-bold text-xs hover:bg-emerald-700 transition shrink-0">
                        Add
                    </button>
                </div>
            </div>
        </form>
    </div>

    <!-- Roster Table & Filters -->
    <div class="bg-white rounded-3xl border border-slate-200 overflow-hidden shadow-xs">
        
        <!-- Filter Bar -->
        <div class="p-5 border-b border-slate-200 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            
            <!-- Status Tabs -->
            <div class="flex items-center gap-1.5 bg-slate-100 p-1 rounded-2xl w-fit">
                <a href="{{ route('admin.events.participants', [$event->id, 'status' => 'all', 'search' => $search]) }}"
                   class="px-3.5 py-1.5 rounded-xl text-xs font-bold transition {{ $attendanceStatus === 'all' ? 'bg-white text-slate-900 shadow-2xs' : 'text-slate-600 hover:text-slate-900' }}">
                    All ({{ $totalRegistrations }})
                </a>
                <a href="{{ route('admin.events.participants', [$event->id, 'status' => 'attended', 'search' => $search]) }}"
                   class="px-3.5 py-1.5 rounded-xl text-xs font-bold transition {{ $attendanceStatus === 'attended' ? 'bg-emerald-600 text-white shadow-2xs' : 'text-slate-600 hover:text-slate-900' }}">
                    Attended ({{ $attendedCount }})
                </a>
                <a href="{{ route('admin.events.participants', [$event->id, 'status' => 'registered', 'search' => $search]) }}"
                   class="px-3.5 py-1.5 rounded-xl text-xs font-bold transition {{ $attendanceStatus === 'registered' ? 'bg-blue-600 text-white shadow-2xs' : 'text-slate-600 hover:text-slate-900' }}">
                    Registered ({{ $totalRegistrations - $attendedCount - $absentCount }})
                </a>
                <a href="{{ route('admin.events.participants', [$event->id, 'status' => 'absent', 'search' => $search]) }}"
                   class="px-3.5 py-1.5 rounded-xl text-xs font-bold transition {{ $attendanceStatus === 'absent' ? 'bg-red-600 text-white shadow-2xs' : 'text-slate-600 hover:text-slate-900' }}">
                    Absent ({{ $absentCount }})
                </a>
            </div>

            <!-- Search -->
            <form method="GET" action="{{ route('admin.events.participants', $event->id) }}" class="flex items-center gap-2">
                <input type="hidden" name="status" value="{{ $attendanceStatus }}">
                <div class="relative w-64">
                    <input type="text" name="search" value="{{ $search }}" placeholder="Search name, phone, email..."
                           class="w-full text-xs rounded-xl border border-slate-300 pl-8 pr-3 py-2 text-slate-900 focus:outline-none focus:ring-2 focus:ring-emerald-500">
                    <svg class="w-3.5 h-3.5 text-slate-400 absolute left-2.5 top-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                </div>
                <button type="submit" class="px-3 py-2 rounded-xl bg-slate-900 text-white text-xs font-bold hover:bg-slate-800 transition">
                    Filter
                </button>
                @if($search)
                    <a href="{{ route('admin.events.participants', [$event->id, 'status' => $attendanceStatus]) }}" class="px-2.5 py-2 rounded-xl bg-slate-100 text-slate-600 text-xs font-bold hover:bg-slate-200 transition">
                        Clear
                    </a>
                @endif
            </form>
        </div>

        <!-- Participants Table -->
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs text-slate-700">
                <thead class="bg-slate-50 text-[11px] uppercase tracking-wider text-slate-500 border-b border-slate-200 font-bold">
                    <tr>
                        <th class="py-3.5 px-4 sm:px-6">Participant Info</th>
                        <th class="py-3.5 px-4">Contact</th>
                        <th class="py-3.5 px-4">Role</th>
                        <th class="py-3.5 px-4">RSVP Date</th>
                        <th class="py-3.5 px-4 text-center">Attendance</th>
                        <th class="py-3.5 px-4 sm:px-6 text-right">Quick Mark</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse ($participants as $reg)
                        <tr class="hover:bg-slate-50/75 transition">
                            <td class="py-3.5 px-4 sm:px-6">
                                <div class="font-bold text-slate-900 text-sm">{{ $reg->participant_name }}</div>
                                @if($reg->volunteer)
                                    <div class="flex items-center gap-1.5 mt-0.5">
                                        <a href="{{ route('admin.volunteers.show', $reg->volunteer->id) }}" class="inline-flex items-center gap-1 text-[11px] font-semibold text-emerald-700 hover:text-emerald-800">
                                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                                            Verified Volunteer: {{ $reg->volunteer->volunteer_code ?: 'View' }}
                                        </a>
                                    </div>
                                @endif
                            </td>
                            <td class="py-3.5 px-4">
                                <div class="font-mono text-slate-900">{{ $reg->participant_phone }}</div>
                                @if($reg->participant_email)
                                    <div class="text-[11px] text-slate-500">{{ $reg->participant_email }}</div>
                                @endif
                            </td>
                            <td class="py-3.5 px-4">
                                <span class="px-2 py-0.5 rounded-lg text-[11px] font-bold {{ $reg->volunteer_id ? 'bg-emerald-50 text-emerald-800 border border-emerald-200' : 'bg-slate-100 text-slate-700 border border-slate-200' }}">
                                    {{ $reg->role_assigned ?: 'Participant' }}
                                </span>
                            </td>
                            <td class="py-3.5 px-4 text-slate-500">
                                {{ $reg->created_at->format('d M Y, h:i A') }}
                            </td>
                            <td class="py-3.5 px-4 text-center">
                                @if($reg->attendance_status === 'attended')
                                    <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-[11px] font-bold bg-emerald-100 text-emerald-800">
                                        <svg class="w-3.5 h-3.5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                        Attended
                                    </span>
                                @elseif($reg->attendance_status === 'absent')
                                    <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-[11px] font-bold bg-red-100 text-red-800">
                                        <svg class="w-3.5 h-3.5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                                        Absent
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-[11px] font-bold bg-blue-100 text-blue-800">
                                        <svg class="w-3.5 h-3.5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                        Registered
                                    </span>
                                @endif
                            </td>
                            <td class="py-3.5 px-4 sm:px-6 text-right">
                                <div class="inline-flex items-center gap-1 bg-slate-100 p-1 rounded-xl">
                                    <form action="{{ route('admin.events.attendance', [$event->id, $reg->id]) }}" method="POST" class="inline">
                                        @csrf
                                        @method('PATCH')
                                        <input type="hidden" name="attendance_status" value="attended">
                                        <button type="submit" title="Mark Present / Attended" class="px-2.5 py-1 rounded-lg text-[11px] font-bold transition {{ $reg->attendance_status === 'attended' ? 'bg-emerald-600 text-white shadow-2xs' : 'text-slate-600 hover:bg-emerald-50 hover:text-emerald-700' }}">
                                            Present
                                        </button>
                                    </form>

                                    <form action="{{ route('admin.events.attendance', [$event->id, $reg->id]) }}" method="POST" class="inline">
                                        @csrf
                                        @method('PATCH')
                                        <input type="hidden" name="attendance_status" value="absent">
                                        <button type="submit" title="Mark Absent" class="px-2.5 py-1 rounded-lg text-[11px] font-bold transition {{ $reg->attendance_status === 'absent' ? 'bg-red-600 text-white shadow-2xs' : 'text-slate-600 hover:bg-red-50 hover:text-red-700' }}">
                                            Absent
                                        </button>
                                    </form>

                                    <form action="{{ route('admin.events.attendance', [$event->id, $reg->id]) }}" method="POST" class="inline">
                                        @csrf
                                        @method('PATCH')
                                        <input type="hidden" name="attendance_status" value="registered">
                                        <button type="submit" title="Reset to Registered" class="px-2 py-1 rounded-lg text-[11px] font-bold transition {{ $reg->attendance_status === 'registered' ? 'bg-blue-600 text-white shadow-2xs' : 'text-slate-600 hover:bg-slate-200' }}">
                                            Reset
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="py-12 text-center text-slate-500">
                                <div class="max-w-xs mx-auto">
                                    <svg class="w-10 h-10 text-slate-300 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                                    <p class="font-bold text-slate-700 text-sm">No registrations found</p>
                                    <p class="text-xs text-slate-400 mt-1">No participants match the selected filter or search term.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($participants->hasPages())
            <div class="p-4 border-t border-slate-200 bg-slate-50">
                {{ $participants->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
