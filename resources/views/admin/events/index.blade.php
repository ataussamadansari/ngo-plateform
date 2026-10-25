@extends('layouts.base')

@section('title', 'Manage Events & Initiatives')

@section('content')
<div class="bg-slate-900 text-white py-8 border-b border-slate-800">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <div class="flex items-center gap-2 mb-1">
                    <span class="px-2.5 py-0.5 rounded-full text-xs font-bold bg-emerald-500/20 text-emerald-300 border border-emerald-500/30">
                        Admin Back-Office
                    </span>
                    <span class="text-xs text-slate-400">Community Drives & Programs</span>
                </div>
                <h1 class="text-2xl sm:text-3xl font-black text-white tracking-tight">
                    Manage Events & Ground Drives
                </h1>
            </div>

            <div class="flex items-center gap-3">
                <a href="{{ route('admin.events.create') }}"
                   class="px-4 py-2.5 rounded-xl font-bold text-xs sm:text-sm bg-primary text-white hover:opacity-95 shadow-md transition flex items-center gap-1.5">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                    <span>Create New Event</span>
                </a>
            </div>
        </div>
    </div>
</div>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

    @if(session('success'))
        <div class="mb-6 p-4 rounded-2xl bg-emerald-50 border border-emerald-200 text-emerald-800 text-sm flex items-center gap-2">
            <svg class="w-5 h-5 text-emerald-600 shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    <!-- Metrics Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-6 mb-8">
        <div class="bg-white rounded-3xl border border-slate-200 p-6 shadow-xs">
            <span class="text-xs font-bold uppercase tracking-wider text-slate-500 block mb-1">Total Events</span>
            <span class="text-3xl font-black text-slate-900 block">{{ $totalEvents }}</span>
            <span class="text-xs text-slate-400 mt-1 block">Past and scheduled drives</span>
        </div>

        <div class="bg-white rounded-3xl border border-emerald-200 bg-emerald-50/20 p-6 shadow-xs">
            <span class="text-xs font-bold uppercase tracking-wider text-emerald-600 block mb-1">Upcoming Events</span>
            <span class="text-3xl font-black text-emerald-700 block">{{ $upcomingCount }}</span>
            <span class="text-xs text-emerald-600/80 mt-1 block">Actively accepting registrations</span>
        </div>

        <div class="bg-white rounded-3xl border border-slate-200 p-6 shadow-xs">
            <span class="text-xs font-bold uppercase tracking-wider text-slate-500 block mb-1">Total Registrations</span>
            <span class="text-3xl font-black text-slate-900 block">{{ $totalRegistrations }}</span>
            <span class="text-xs text-slate-400 mt-1 block">Volunteers & community participants</span>
        </div>
    </div>

    <!-- Filter Bar -->
    <div class="bg-white rounded-3xl border border-slate-200 p-4 sm:p-6 mb-8 shadow-xs">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div class="flex items-center gap-1.5 overflow-x-auto pb-2 md:pb-0 scrollbar-none">
                @foreach(['all' => 'All Events', 'upcoming' => 'Upcoming', 'ongoing' => 'Ongoing', 'completed' => 'Completed', 'cancelled' => 'Cancelled'] as $val => $label)
                    <a href="{{ route('admin.events.index', array_merge(request()->except('status', 'page'), ['status' => $val])) }}"
                       class="px-4 py-2 rounded-xl text-xs sm:text-sm font-bold transition whitespace-nowrap {{ ($status === $val || (empty($status) && $val === 'all')) ? 'bg-slate-900 text-white shadow-xs' : 'bg-slate-100 text-slate-600 hover:bg-slate-200' }}">
                        {{ $label }}
                    </a>
                @endforeach
            </div>

            <form action="{{ route('admin.events.index') }}" method="GET" class="flex items-center gap-2 max-w-md w-full">
                <input type="hidden" name="status" value="{{ $status }}">
                <div class="relative flex-grow">
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Search events by title or location..."
                           class="w-full text-xs sm:text-sm rounded-xl border border-slate-300 pl-9 pr-3 py-2 text-slate-800 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-emerald-500">
                    <svg class="w-4 h-4 text-slate-400 absolute left-3 top-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                </div>
                <button type="submit" class="px-4 py-2 bg-slate-900 text-white rounded-xl text-xs sm:text-sm font-semibold hover:bg-slate-800 transition">
                    Filter
                </button>
                @if(request()->filled('search'))
                    <a href="{{ route('admin.events.index', ['status' => $status]) }}" class="p-2 text-slate-400 hover:text-slate-600 text-xs">Clear</a>
                @endif
            </form>
        </div>
    </div>

    <!-- Events Table -->
    <div class="bg-white rounded-3xl border border-slate-200 shadow-xs overflow-hidden">
        @if($events->count() > 0)
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse text-xs sm:text-sm">
                    <thead>
                        <tr class="bg-slate-50 border-b border-slate-200 text-slate-500 uppercase tracking-wider text-[11px] font-bold">
                            <th class="py-3.5 px-4 sm:px-6">Event Details</th>
                            <th class="py-3.5 px-4">Date & Timing</th>
                            <th class="py-3.5 px-4">Venue</th>
                            <th class="py-3.5 px-4">Capacity & Registrations</th>
                            <th class="py-3.5 px-4">Status</th>
                            <th class="py-3.5 px-4 sm:px-6 text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @foreach($events as $event)
                            <tr class="hover:bg-slate-50/70 transition">
                                <!-- Details -->
                                <td class="py-4 px-4 sm:px-6">
                                    <div class="flex items-center gap-3">
                                        @if($event->banner_image)
                                            <img src="{{ asset('storage/' . $event->banner_image) }}"
                                                 alt="{{ $event->title }}"
                                                 class="w-12 h-12 rounded-xl object-cover border border-slate-200 shrink-0">
                                        @else
                                            <div class="w-12 h-12 rounded-xl bg-slate-100 text-slate-500 font-bold flex items-center justify-center shrink-0">
                                                EV
                                            </div>
                                        @endif
                                        <div>
                                            <a href="{{ route('events.show', $event->slug) }}" target="_blank" class="font-bold text-slate-900 hover:text-emerald-700 transition line-clamp-1">
                                                {{ $event->title }}
                                            </a>
                                            <span class="text-[11px] text-slate-400 block mt-0.5">/events/{{ $event->slug }}</span>
                                        </div>
                                    </div>
                                </td>

                                <!-- Date & Time -->
                                <td class="py-4 px-4">
                                    <div class="font-bold text-slate-800 text-xs">{{ $event->event_date?->format('d M, Y') }}</div>
                                    <div class="text-[11px] text-slate-500 mt-0.5">{{ date('h:i A', strtotime($event->start_time)) }}</div>
                                </td>

                                <!-- Venue -->
                                <td class="py-4 px-4 max-w-xs">
                                    <div class="font-medium text-slate-900 text-xs">{{ $event->location_name }}</div>
                                    <div class="text-[11px] text-slate-500 line-clamp-1 mt-0.5">{{ $event->address }}</div>
                                </td>

                                <!-- Capacity -->
                                <td class="py-4 px-4">
                                    <div class="font-bold text-slate-900 text-xs">
                                        {{ $event->registrations_count }} @if($event->max_participants) / {{ $event->max_participants }} @else registered @endif
                                    </div>
                                    @if($event->max_participants)
                                        <div class="w-24 bg-slate-100 rounded-full h-1.5 mt-1 overflow-hidden">
                                            <div class="bg-primary h-1.5 rounded-full" style="width: {{ min(100, round(($event->registrations_count / $event->max_participants) * 100)) }}%"></div>
                                        </div>
                                    @endif
                                </td>

                                <!-- Status -->
                                <td class="py-4 px-4">
                                    @if($event->status === 'upcoming')
                                        <span class="px-2.5 py-1 rounded-full text-xs font-bold bg-emerald-50 text-emerald-700 border border-emerald-200">
                                            Upcoming
                                        </span>
                                    @elseif($event->status === 'ongoing')
                                        <span class="px-2.5 py-1 rounded-full text-xs font-bold bg-amber-50 text-amber-700 border border-amber-200 animate-pulse">
                                            Ongoing
                                        </span>
                                    @elseif($event->status === 'completed')
                                        <span class="px-2.5 py-1 rounded-full text-xs font-bold bg-slate-100 text-slate-600">
                                            Completed
                                        </span>
                                    @elseif($event->status === 'cancelled')
                                        <span class="px-2.5 py-1 rounded-full text-xs font-bold bg-red-50 text-red-700 border border-red-200">
                                            Cancelled
                                        </span>
                                    @endif
                                </td>

                                <!-- Actions -->
                                <td class="py-4 px-4 sm:px-6 text-right">
                                    <div class="flex items-center justify-end gap-2">
                                        <a href="{{ route('admin.events.participants', $event->id) }}"
                                           class="px-3 py-1.5 rounded-xl bg-slate-900 text-white font-bold hover:bg-slate-800 transition text-xs shadow-xs">
                                            Roster & Attendance ({{ $event->registrations_count }})
                                        </a>

                                        <a href="{{ route('admin.events.edit', $event->id) }}"
                                           class="p-1.5 rounded-xl border border-slate-300 text-slate-600 hover:bg-slate-50 transition" title="Edit Event">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="p-4 border-t border-slate-100">
                {{ $events->links() }}
            </div>
        @else
            <div class="text-center py-12 p-6">
                <div class="w-12 h-12 rounded-full bg-slate-100 text-slate-400 flex items-center justify-center mx-auto mb-3">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                </div>
                <h3 class="text-sm font-bold text-slate-800">No events found</h3>
                <p class="text-xs text-slate-500 mt-1">Get started by scheduling your first volunteer relief drive or health camp.</p>
                <a href="{{ route('admin.events.create') }}" class="mt-4 inline-block px-4 py-2 rounded-xl bg-primary text-white font-bold text-xs">
                    Create Event
                </a>
            </div>
        @endif
    </div>

</div>
@endsection
