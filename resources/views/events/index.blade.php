@extends('layouts.base')

@section('title', 'Community Relief Drives & Volunteer Events')

@section('content')
<div class="bg-gradient-to-b from-slate-100 to-white py-10 sm:py-14 border-b border-slate-200">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-emerald-50 text-emerald-700 border border-emerald-200 mb-4 shadow-xs">
            Community Mobilization &bull; Ground Relief
        </span>
        <h1 class="text-3xl sm:text-5xl font-black text-slate-900 tracking-tight">
            Community Relief Drives & Events
        </h1>
        <p class="mt-3 text-base sm:text-lg text-slate-600 max-w-2xl mx-auto leading-relaxed">
            Join our on-ground team. From free health camps to emergency ration distribution and child education workshops, participate and make a tangible difference.
        </p>
    </div>
</div>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">

    <!-- Filter, Search & Tab Bar -->
    <div class="bg-white rounded-3xl border border-slate-200 p-4 sm:p-6 mb-8 shadow-xs">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            <!-- Event Type Switcher Tabs -->
            <div class="flex items-center gap-2">
                <a href="{{ route('events.index', array_merge(request()->except('type', 'page'), ['type' => 'upcoming'])) }}"
                   class="px-4 py-2 rounded-xl text-xs sm:text-sm font-bold transition {{ $type !== 'past' ? 'bg-primary text-white shadow-xs' : 'bg-slate-100 text-slate-600 hover:bg-slate-200' }}">
                    Upcoming Events
                </a>
                <a href="{{ route('events.index', array_merge(request()->except('type', 'page'), ['type' => 'past'])) }}"
                   class="px-4 py-2 rounded-xl text-xs sm:text-sm font-bold transition {{ $type === 'past' ? 'bg-primary text-white shadow-xs' : 'bg-slate-100 text-slate-600 hover:bg-slate-200' }}">
                    Past Completed Drives
                </a>
            </div>

            <!-- Search Form -->
            <form action="{{ route('events.index') }}" method="GET" class="flex items-center gap-2 max-w-md w-full">
                <input type="hidden" name="type" value="{{ $type }}">
                <div class="relative flex-grow">
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Search events by name or location..."
                           class="w-full text-xs sm:text-sm rounded-xl border border-slate-300 pl-9 pr-3 py-2 text-slate-800 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-emerald-500">
                    <svg class="w-4 h-4 text-slate-400 absolute left-3 top-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                </div>
                <button type="submit" class="px-4 py-2 bg-slate-900 text-white rounded-xl text-xs sm:text-sm font-semibold hover:bg-slate-800 transition">
                    Search
                </button>
                @if(request()->filled('search'))
                    <a href="{{ route('events.index', ['type' => $type]) }}" class="p-2 text-slate-400 hover:text-slate-600 text-xs">Clear</a>
                @endif
            </form>
        </div>
    </div>

    <!-- Events 3-Column Grid -->
    @if($events->count() > 0)
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach($events as $event)
                <div class="bg-white rounded-3xl border border-slate-200 overflow-hidden shadow-xs hover:shadow-lg transition-all duration-300 flex flex-col justify-between group">
                    <div>
                        <!-- Event Banner -->
                        <div class="relative aspect-video bg-slate-100 overflow-hidden">
                            @if($event->banner_image)
                                <img src="{{ asset('storage/' . $event->banner_image) }}"
                                     alt="{{ $event->title }}"
                                     class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                            @else
                                <div class="w-full h-full flex items-center justify-center bg-gradient-to-br from-emerald-600 to-slate-800 text-white font-bold text-lg">
                                    {{ setting('ngo_name', 'NGO Event') }}
                                </div>
                            @endif

                            <div class="absolute top-3 left-3">
                                @if($event->status === 'upcoming')
                                    <span class="px-2.5 py-1 rounded-lg text-[11px] font-bold bg-emerald-600 text-white shadow-xs">
                                        Upcoming Drive
                                    </span>
                                @elseif($event->status === 'ongoing')
                                    <span class="px-2.5 py-1 rounded-lg text-[11px] font-bold bg-amber-500 text-white shadow-xs animate-pulse">
                                        Happening Now
                                    </span>
                                @elseif($event->status === 'completed')
                                    <span class="px-2.5 py-1 rounded-lg text-[11px] font-bold bg-slate-900/90 text-white shadow-xs">
                                        Concluded
                                    </span>
                                @endif
                            </div>

                            @if($event->max_participants && $event->registrations_count >= $event->max_participants)
                                <div class="absolute top-3 right-3">
                                    <span class="px-2 py-0.5 rounded-md text-[10px] font-bold bg-red-600 text-white shadow-xs">
                                        Full Capacity
                                    </span>
                                </div>
                            @endif
                        </div>

                        <!-- Event Content -->
                        <div class="p-6">
                            <!-- Date & Time Strip -->
                            <div class="flex items-center gap-2 text-xs font-bold text-emerald-700 mb-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                <span>{{ $event->event_date?->format('d M, Y') }} &bull; {{ date('h:i A', strtotime($event->start_time)) }}</span>
                            </div>

                            <h3 class="text-lg font-bold text-slate-900 group-hover:text-emerald-700 transition leading-snug line-clamp-2 mb-2">
                                <a href="{{ route('events.show', $event->slug) }}">
                                    {{ $event->title }}
                                </a>
                            </h3>

                            <!-- Location Preview -->
                            <div class="flex items-start gap-1.5 text-xs text-slate-500 mb-4">
                                <svg class="w-4 h-4 text-slate-400 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                <span class="line-clamp-1">{{ $event->location_name }}</span>
                            </div>

                            <p class="text-xs text-slate-600 line-clamp-2 leading-relaxed">
                                {{ Str::limit(strip_tags($event->description), 110) }}
                            </p>
                        </div>
                    </div>

                    <!-- Event Card Footer -->
                    <div class="px-6 pb-6 pt-3 border-t border-slate-100 bg-slate-50/50 flex items-center justify-between">
                        <div class="text-xs">
                            <span class="font-bold text-slate-800">{{ $event->registrations_count }}</span>
                            <span class="text-slate-500">
                                @if($event->max_participants)
                                    / {{ $event->max_participants }} spots
                                @else
                                    participants
                                @endif
                            </span>
                        </div>

                        <a href="{{ route('events.show', $event->slug) }}"
                           class="py-2 px-4 rounded-xl text-xs font-bold text-slate-700 bg-white border border-slate-300 hover:bg-slate-50 hover:border-slate-400 transition shadow-xs">
                            {{ $event->status === 'upcoming' ? 'RSVP / Details &rarr;' : 'View Summary &rarr;' }}
                        </a>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="mt-10">
            {{ $events->links() }}
        </div>
    @else
        <div class="text-center py-16 bg-white rounded-3xl border border-slate-200 p-8 shadow-xs">
            <div class="w-16 h-16 rounded-full bg-slate-100 text-slate-400 flex items-center justify-center mx-auto mb-4">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
            </div>
            <h3 class="text-lg font-bold text-slate-800 mb-1">No events found</h3>
            <p class="text-xs sm:text-sm text-slate-500 max-w-sm mx-auto mb-6">
                There are currently no events matching your criteria. Check back soon for upcoming community relief drives.
            </p>
            <a href="{{ route('events.index') }}" class="px-5 py-2.5 bg-slate-900 text-white rounded-xl text-xs font-bold hover:bg-slate-800 transition">
                Reset Filter
            </a>
        </div>
    @endif

</div>
@endsection
