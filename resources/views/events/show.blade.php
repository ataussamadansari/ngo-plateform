@extends('layouts.base')

@section('title', $event->title)

@section('content')
<!-- Event Header -->
<div class="bg-gradient-to-b from-slate-100 to-white py-8 sm:py-12 border-b border-slate-200">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center gap-2 mb-3">
            <a href="{{ route('events.index') }}" class="text-xs font-semibold text-slate-500 hover:text-slate-800 transition flex items-center gap-1">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                All Events
            </a>
            <span class="text-slate-300">&bull;</span>
            @if($event->status === 'upcoming')
                <span class="px-2.5 py-0.5 rounded-full text-xs font-bold bg-emerald-50 text-emerald-700 border border-emerald-200">
                    Upcoming Event
                </span>
            @elseif($event->status === 'ongoing')
                <span class="px-2.5 py-0.5 rounded-full text-xs font-bold bg-amber-50 text-amber-700 border border-amber-200 animate-pulse">
                    Happening Today
                </span>
            @elseif($event->status === 'completed')
                <span class="px-2.5 py-0.5 rounded-full text-xs font-bold bg-slate-200 text-slate-700">
                    Concluded
                </span>
            @elseif($event->status === 'cancelled')
                <span class="px-2.5 py-0.5 rounded-full text-xs font-bold bg-red-50 text-red-700 border border-red-200">
                    Cancelled
                </span>
            @endif
        </div>

        <h1 class="text-2xl sm:text-4xl font-black text-slate-900 tracking-tight leading-tight max-w-4xl">
            {{ $event->title }}
        </h1>

        <div class="flex flex-wrap items-center gap-4 sm:gap-6 mt-4 text-xs sm:text-sm text-slate-600">
            <div class="flex items-center gap-1.5 font-semibold text-emerald-800">
                <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                <span>{{ $event->event_date?->format('l, d F Y') }}</span>
            </div>

            <div class="flex items-center gap-1.5 font-medium text-slate-700">
                <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                <span>{{ date('h:i A', strtotime($event->start_time)) }} @if($event->end_time) - {{ date('h:i A', strtotime($event->end_time)) }} @endif</span>
            </div>

            <div class="flex items-center gap-1.5 font-medium text-slate-700">
                <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                <span>{{ $event->location_name }}</span>
            </div>
        </div>
    </div>
</div>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">

    @if(session('success'))
        <div class="mb-8 p-4 rounded-2xl bg-emerald-50 border border-emerald-200 text-emerald-800 text-sm flex items-center gap-2">
            <svg class="w-5 h-5 text-emerald-600 shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    @if(session('error'))
        <div class="mb-8 p-4 rounded-2xl bg-red-50 border border-red-200 text-red-800 text-sm flex items-center gap-2">
            <svg class="w-5 h-5 text-red-600 shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/></svg>
            <span>{{ session('error') }}</span>
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-10">

        <!-- Left Column: Banner, Details, Venue (8 cols) -->
        <div class="lg:col-span-8 space-y-8">

            <!-- Banner Photo -->
            <div class="rounded-3xl overflow-hidden border border-slate-200 bg-slate-100 shadow-xs relative aspect-video">
                @if($event->banner_image)
                    <img src="{{ asset('storage/' . $event->banner_image) }}"
                         alt="{{ $event->title }}"
                         class="w-full h-full object-cover">
                @else
                    <div class="w-full h-full flex items-center justify-center bg-gradient-to-br from-emerald-600 to-slate-900 text-white font-black text-2xl">
                        {{ setting('ngo_name', 'NGO Event') }}
                    </div>
                @endif
            </div>

            <!-- Description -->
            <div class="bg-white rounded-3xl border border-slate-200 p-6 sm:p-8 shadow-xs">
                <h2 class="text-xl sm:text-2xl font-black text-slate-900 mb-6 flex items-center gap-3">
                    <span class="w-2.5 h-6 bg-primary rounded-full"></span>
                    About This Initiative
                </h2>
                <div class="prose prose-slate max-w-none text-slate-700 leading-relaxed space-y-4 text-sm sm:text-base">
                    {!! nl2br(e($event->description)) !!}
                </div>
            </div>

            <!-- Venue & Directions Card -->
            <div class="bg-white rounded-3xl border border-slate-200 p-6 sm:p-8 shadow-xs">
                <h2 class="text-lg sm:text-xl font-bold text-slate-900 mb-4 flex items-center gap-2">
                    <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                    Venue & Location Directions
                </h2>

                <div class="p-4 rounded-2xl bg-slate-50 border border-slate-200 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                    <div>
                        <span class="font-bold text-slate-900 block text-sm">{{ $event->location_name }}</span>
                        <p class="text-xs text-slate-600 mt-1 leading-relaxed">{{ $event->address }}</p>
                    </div>

                    @if($event->google_map_link)
                        <a href="{{ $event->google_map_link }}" target="_blank" rel="noopener noreferrer"
                           class="px-4 py-2.5 rounded-xl bg-slate-900 text-white font-bold text-xs hover:bg-slate-800 transition inline-flex items-center gap-1.5 shrink-0 self-start sm:self-center shadow-xs">
                            <svg class="w-4 h-4 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                            <span>Open in Google Maps</span>
                        </a>
                    @endif
                </div>
            </div>

        </div>

        <!-- Right Sticky Column: RSVP & Capacity Card (4 cols) -->
        <div class="lg:col-span-4">
            <div class="sticky top-24 space-y-6">

                <!-- Capacity & Schedule Summary Card -->
                <div class="bg-white rounded-3xl border border-slate-200 p-6 sm:p-7 shadow-lg">
                    <span class="text-xs font-bold uppercase tracking-wider text-slate-400 block mb-2">Registration Status</span>

                    <div class="flex justify-between items-baseline mb-2">
                        <span class="text-2xl font-black text-slate-900">
                            {{ $event->registrations_count }} Registered
                        </span>
                        @if($event->max_participants)
                            <span class="text-xs font-bold text-slate-500">
                                Max {{ $event->max_participants }}
                            </span>
                        @endif
                    </div>

                    @if($event->max_participants)
                        @php
                            $fillPercent = min(100, round(($event->registrations_count / $event->max_participants) * 100));
                        @endphp
                        <div class="w-full bg-slate-100 rounded-full h-2.5 mb-4 overflow-hidden">
                            <div class="bg-primary h-2.5 rounded-full" style="width: {{ $fillPercent }}%"></div>
                        </div>
                    @endif

                    <!-- RSVP Registration Form -->
                    @if(in_array($event->status, ['upcoming', 'ongoing'], true) && !$isFull)
                        <div class="pt-4 border-t border-slate-100">
                            <h3 class="text-sm font-bold text-slate-900 mb-3">RSVP to Attend or Volunteer</h3>

                            <form action="{{ route('events.register', $event->slug) }}" method="POST" class="space-y-3.5">
                                @csrf

                                <div>
                                    <label for="participant_name" class="block text-[11px] font-bold uppercase tracking-wider text-slate-600 mb-1">
                                        Your Full Name <span class="text-red-500">*</span>
                                    </label>
                                    <input type="text" name="participant_name" id="participant_name" required
                                           value="{{ old('participant_name') }}"
                                           placeholder="e.g. Priya Sharma"
                                           class="w-full text-xs rounded-xl border border-slate-300 px-3 py-2 text-slate-900 focus:outline-none focus:ring-2 focus:ring-emerald-500">
                                </div>

                                <div>
                                    <label for="participant_phone" class="block text-[11px] font-bold uppercase tracking-wider text-slate-600 mb-1">
                                        Phone Number <span class="text-red-500">*</span>
                                    </label>
                                    <input type="tel" name="participant_phone" id="participant_phone" required
                                           value="{{ old('participant_phone') }}"
                                           placeholder="+91 9876543210"
                                           class="w-full text-xs rounded-xl border border-slate-300 px-3 py-2 text-slate-900 focus:outline-none focus:ring-2 focus:ring-emerald-500">
                                </div>

                                <div>
                                    <label for="participant_email" class="block text-[11px] font-bold uppercase tracking-wider text-slate-600 mb-1">
                                        Email Address <span class="text-slate-400 font-normal">(Optional)</span>
                                    </label>
                                    <input type="email" name="participant_email" id="participant_email"
                                           value="{{ old('participant_email') }}"
                                           placeholder="priya@example.com"
                                           class="w-full text-xs rounded-xl border border-slate-300 px-3 py-2 text-slate-900 focus:outline-none focus:ring-2 focus:ring-emerald-500">
                                </div>

                                <button type="submit"
                                        class="w-full py-3.5 px-4 rounded-2xl font-black text-sm text-white bg-primary hover:opacity-95 shadow-md hover:shadow-lg transition">
                                    Confirm RSVP
                                </button>
                                <p class="text-center text-[10px] text-slate-400">Approved volunteers are automatically linked & recognized</p>
                            </form>
                        </div>
                    @elseif($isFull)
                        <div class="p-4 rounded-2xl bg-red-50 border border-red-200 text-center text-xs text-red-800 font-bold">
                            Full Capacity Reached. Registration is closed.
                        </div>
                    @else
                        <div class="p-4 rounded-2xl bg-slate-50 border border-slate-200 text-center text-xs text-slate-600 font-semibold">
                            This event has concluded.
                        </div>
                    @endif
                </div>

                <!-- Volunteer Callout -->
                <div class="bg-gradient-to-br from-slate-900 to-slate-800 text-white rounded-3xl p-6 shadow-md border border-slate-700">
                    <span class="text-xs font-bold uppercase tracking-wider text-emerald-400 block mb-1">Join as a Volunteer</span>
                    <h3 class="text-base font-bold text-white mb-2">Want to lead drives like this?</h3>
                    <p class="text-xs text-slate-400 leading-relaxed mb-4">
                        Register with our volunteer community to get assigned leadership roles and official identification credentials.
                    </p>
                    <a href="{{ route('volunteers.create') }}" class="inline-block py-2.5 px-4 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs transition">
                        Apply to Volunteer &rarr;
                    </a>
                </div>

            </div>
        </div>

    </div>
</div>
@endsection
